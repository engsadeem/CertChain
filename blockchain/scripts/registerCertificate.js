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
  if (!value || value.trim() === '') {
    throw new Error(`${name} is not configured.`);
  }
  return value.trim();
}

function normalizePrivateKey(value) {
  const key = value.trim();
  return key.startsWith('0x') ? key : `0x${key}`;
}

function normalizeBytes32(value) {
  const hash = value.trim();
  if (!/^0x[a-fA-F0-9]{64}$/.test(hash)) {
    throw new Error('Certificate hash must be a bytes32 value such as 0x followed by 64 hex characters.');
  }
  return hash;
}

function certificateKey(certificateId) {
  return ethers.toBigInt(ethers.keccak256(ethers.toUtf8Bytes(certificateId)));
}

function candidates(preferredType = 'auto', preferredFunction = 'registerCertificate') {
  const all = [
    {
      functionName: preferredFunction,
      idType: 'uint256',
      abi: [
        `function ${preferredFunction}(uint256 certId, bytes32 certificateHash)`,
        'function verifyCertificate(uint256 certId, bytes32 certificateHash) view returns (bool)',
      ],
      args: (certificateId, hash) => [certificateKey(certificateId), hash],
    },
    {
      functionName: preferredFunction,
      idType: 'string',
      abi: [
        `function ${preferredFunction}(string certId, bytes32 certificateHash)`,
        'function verifyCertificate(string certId, bytes32 certificateHash) view returns (bool)',
      ],
      args: (certificateId, hash) => [certificateId, hash],
    },
    {
      functionName: 'issueCertificate',
      idType: 'uint256',
      abi: [
        'function issueCertificate(uint256 certId, bytes32 certificateHash)',
        'function verifyCertificate(uint256 certId, bytes32 certificateHash) view returns (bool)',
      ],
      args: (certificateId, hash) => [certificateKey(certificateId), hash],
    },
    {
      functionName: 'issueCertificate',
      idType: 'string',
      abi: [
        'function issueCertificate(string certId, bytes32 certificateHash)',
        'function verifyCertificate(string certId, bytes32 certificateHash) view returns (bool)',
      ],
      args: (certificateId, hash) => [certificateId, hash],
    },
  ];

  return all.filter((candidate) => {
    const typeMatches = preferredType === 'auto' || candidate.idType === preferredType;
    const fnMatches = candidate.functionName === preferredFunction || candidate.functionName !== 'registerCertificate';
    return typeMatches && fnMatches;
  });
}

async function main() {
  loadLocalEnv();

  const certificateId = process.argv[2];
  const certificateHash = normalizeBytes32(process.argv[3] || '');

  if (!certificateId || certificateId.trim() === '') {
    throw new Error('Certificate ID is required.');
  }

  const rpcUrl = requiredEnv('ETH_RPC_URL');
  const contractAddress = requiredEnv('ETH_CONTRACT_ADDRESS');
  const privateKey = normalizePrivateKey(requiredEnv('ETH_PRIVATE_KEY'));
  const expectedChainId = BigInt(process.env.ETH_CHAIN_ID || '11155111');
  const confirmations = Number.parseInt(process.env.ETH_CONFIRMATIONS || '1', 10);
  const preferredType = process.env.ETH_CERTIFICATE_ID_TYPE || 'auto';
  const preferredFunction = process.env.ETH_REGISTER_FUNCTION || 'registerCertificate';

  if (!ethers.isAddress(contractAddress)) {
    throw new Error('ETH_CONTRACT_ADDRESS is not a valid Ethereum address.');
  }

  const provider = new ethers.JsonRpcProvider(rpcUrl);
  const network = await provider.getNetwork();

  if (network.chainId !== expectedChainId) {
    throw new Error(`RPC chain mismatch. Expected ${expectedChainId.toString()} but connected to ${network.chainId.toString()}.`);
  }

  const wallet = new ethers.Wallet(privateKey, provider);
  const contractCode = await provider.getCode(contractAddress);
  if (!contractCode || contractCode === '0x') {
    throw new Error(`No smart contract code found at ${contractAddress}. Check ETH_CONTRACT_ADDRESS and network.`);
  }

  const attempts = [];
  for (const candidate of candidates(preferredType, preferredFunction)) {
    const contract = new ethers.Contract(contractAddress, candidate.abi, wallet);
    const args = candidate.args(certificateId, certificateHash);

    try {
      await contract[candidate.functionName].staticCall(...args);
      const tx = await contract[candidate.functionName](...args);
      const receipt = await tx.wait(Number.isFinite(confirmations) ? confirmations : 1);

      let verified = null;
      try {
        verified = await contract.verifyCertificate.staticCall(...args);
      } catch (_) {
        verified = null;
      }

      jsonExit({
        success: true,
        certificate_id: certificateId,
        cert_key: certificateKey(certificateId).toString(),
        certificate_hash: certificateHash,
        tx_hash: tx.hash,
        block_number: receipt?.blockNumber?.toString() || null,
        gas_used: receipt?.gasUsed?.toString() || null,
        smart_contract: contractAddress,
        network: process.env.ETH_NETWORK || 'sepolia',
        chain_id: network.chainId.toString(),
        method: candidate.functionName,
        id_type: candidate.idType,
        verified,
      });
    } catch (error) {
      attempts.push(`${candidate.functionName}(${candidate.idType},bytes32): ${error.shortMessage || error.reason || error.message}`);
    }
  }

  throw new Error(`Smart contract registration failed. Tried: ${attempts.join(' | ')}`);
}

main().catch((error) => {
  jsonExit({ success: false, error: error.shortMessage || error.reason || error.message }, 1);
});
