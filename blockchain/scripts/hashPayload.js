#!/usr/bin/env node
import { ethers } from 'ethers';

function jsonExit(payload, code = 0) {
  process.stdout.write(JSON.stringify(payload, null, 2));
  process.exit(code);
}

try {
  const encoded = process.argv[2];
  if (!encoded) {
    jsonExit({ success: false, error: 'Missing base64 encoded canonical payload.' }, 1);
  }

  const canonicalJson = Buffer.from(encoded, 'base64').toString('utf8');
  JSON.parse(canonicalJson);

  jsonExit({
    success: true,
    algorithm: 'keccak256',
    hash: ethers.keccak256(ethers.toUtf8Bytes(canonicalJson)),
  });
} catch (error) {
  jsonExit({ success: false, error: error.message }, 1);
}
