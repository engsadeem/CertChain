#!/usr/bin/env node
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { ethers } from 'ethers';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '..', '..');

function loadLocalEnv() {
  const envPath = path.join(projectRoot, '.env');
  if (!fs.existsSync(envPath)) return;
  const lines = fs.readFileSync(envPath, 'utf8').split(/\r?\n/);
  for (const line of lines) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith('#') || !trimmed.includes('=')) continue;
    const index = trimmed.indexOf('=');
    const key = trimmed.slice(0, index).trim();
    let value = trimmed.slice(index + 1).trim();
    if ((value.startsWith('"') && value.endsWith('"')) || (value.startsWith("'") && value.endsWith("'"))) {
      value = value.slice(1, -1);
    }
    if (!process.env[key]) process.env[key] = value;
  }
}

function jsonExit(payload, code = 0) {
  process.stdout.write(JSON.stringify(payload, null, 2));
  process.exit(code);
}

function requiredEnv(name) {
  const value = process.env[name];
  if (!value || value.trim() === '') throw new Error(`${name} is not configured.`);
  return value.trim();
}

function normalizeBytes32(value) {
  const hash = value.trim();
  if (!/^0x[a-fA-F0-9]{64}$/.test(hash)) throw new Error('Certificate hash must be bytes32.');
  return hash;
}

function certificateKey(certificateId) {
  return ethers.toBigInt(ethers.keccak256(ethers.toUtf8Bytes(certificateId)));
}

async function main() {
  loadLocalEnv();

  const certificateId = process.argv[2];
  const certificateHash = normalizeBytes32(process.argv[3] || '');
  if (!certificateId || certificateId.trim() === '') throw new Error('Certificate ID is required.');

  const rpcUrl = requiredEnv('ETH_RPC_URL');
  const contractAddress = requiredEnv('ETH_CONTRACT_ADDRESS');
  const expectedChainId = BigInt(process.env.ETH_CHAIN_ID || '11155111');

  if (!ethers.isAddress(contractAddress)) throw new Error('ETH_CONTRACT_ADDRESS is not a valid Ethereum address.');

  const provider = new ethers.JsonRpcProvider(rpcUrl);
  const network = await provider.getNetwork();
  if (network.chainId !== expectedChainId) {
    throw new Error(`RPC chain mismatch. Expected ${expectedChainId.toString()} but connected to ${network.chainId.toString()}.`);
  }

  const contractCode = await provider.getCode(contractAddress);
  if (!contractCode || contractCode === '0x') {
    throw new Error(`No smart contract code found at ${contractAddress}.`);
  }

  const attempts = [];
  const candidates = [
    {
      idType: 'uint256',
      abi: [
        'function verifyCertificate(uint256 certId, bytes32 certificateHash) view returns (bool)',
        'function certificateHashes(uint256 certId) view returns (bytes32)',
        'function certificateTimestamps(uint256 certId) view returns (uint256)',
        'function getTimestamp(uint256 certId) view returns (uint256)',
      ],
      args: [certificateKey(certificateId), certificateHash],
      key: certificateKey(certificateId),
    },
    {
      idType: 'string',
      abi: [
        'function verifyCertificate(string certId, bytes32 certificateHash) view returns (bool)',
        'function certificateHashes(string certId) view returns (bytes32)',
        'function certificateTimestamps(string certId) view returns (uint256)',
        'function getTimestamp(string certId) view returns (uint256)',
      ],
      args: [certificateId, certificateHash],
      key: certificateId,
    },
  ];

  for (const candidate of candidates) {
    const contract = new ethers.Contract(contractAddress, candidate.abi, provider);
    try {
      const verified = await contract.verifyCertificate.staticCall(...candidate.args);
      let storedHash = null;
      let timestamp = null;

      try { storedHash = await contract.certificateHashes.staticCall(candidate.key); } catch (_) {}
      try { timestamp = (await contract.getTimestamp.staticCall(candidate.key)).toString(); } catch (_) {}
      if (!timestamp) {
        try { timestamp = (await contract.certificateTimestamps.staticCall(candidate.key)).toString(); } catch (_) {}
      }

      jsonExit({
        success: true,
        verified: Boolean(verified),
        certificate_id: certificateId,
        cert_key: certificateKey(certificateId).toString(),
        certificate_hash: certificateHash,
        stored_hash: storedHash,
        timestamp,
        smart_contract: contractAddress,
        network: process.env.ETH_NETWORK || 'sepolia',
        chain_id: network.chainId.toString(),
        id_type: candidate.idType,
      });
    } catch (error) {
      attempts.push(`verifyCertificate(${candidate.idType},bytes32): ${error.shortMessage || error.reason || error.message}`);
    }
  }

  throw new Error(`Smart contract verification failed. Tried: ${attempts.join(' | ')}`);
}

main().catch((error) => {
  jsonExit({ success: false, error: error.shortMessage || error.reason || error.message }, 1);
});
