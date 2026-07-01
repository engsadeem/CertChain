# CertChain blockchain integration

## What was broken

The previous Issue flow did not create an Ethereum transaction. It generated a local placeholder only:

```php
$txHash = 'local-' . (string) Str::uuid();
```

Because of that, certificates were saved in MySQL but no new entry appeared on Sepolia Etherscan.

## What the fixed version does

The fixed flow now follows the project design:

1. The backend receives student data and the certificate PDF.
2. The PDF is hashed locally with SHA-256.
3. A canonical certificate payload is built from:
   - certificate_id
   - student_name
   - student_id
   - university
   - degree
   - graduation_date
   - pdf_sha256
4. The backend generates a Keccak-256 fingerprint for that payload.
5. The backend sends a Sepolia transaction to the smart contract:

```solidity
registerCertificate(uint256 certId, bytes32 certificateHash)
```

6. After the transaction is mined, the real tx hash and block number are saved in MySQL.
7. Verification checks both the local database and the smart contract.

## Required contract

Use this contract in Remix:

```text
blockchain/contracts/CertificateRegistry.sol
```

Deploy it on Sepolia using the same wallet that will be configured in `.env` as `ETH_PRIVATE_KEY`, because the contract allows only the owner/deployer to register certificates.

## Required `.env` values

```env
ETHERSCAN_BASE_URL=https://sepolia.etherscan.io
ETH_NETWORK=sepolia
ETH_NETWORK_NAME="Sepolia Testnet"
ETH_CHAIN_ID=11155111
ETH_RPC_URL=https://eth-sepolia.g.alchemy.com/v2/YOUR_ALCHEMY_KEY
ETH_CONTRACT_ADDRESS=0xYOUR_DEPLOYED_CONTRACT_ADDRESS
ETH_PRIVATE_KEY=YOUR_TESTNET_WALLET_PRIVATE_KEY
ETH_LAST_TX_HASH=0xOPTIONAL_DEPLOY_TRANSACTION_HASH
ETH_CONFIRMATIONS=1
ETH_CERTIFICATE_ID_TYPE=uint256
ETH_REGISTER_FUNCTION=registerCertificate
NODE_BINARY=node
```

Never commit `.env` to GitHub or send it to other people.

## Install / update dependencies

```bash
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan optimize:clear
php artisan migrate --seed
npm run build
```

## Run the project

Terminal 1:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Terminal 2:

```bash
npm run dev
```

Open:

```text
http://127.0.0.1:8000
```

## Test blockchain manually

After `.env` is configured and the contract is deployed:

```bash
node blockchain/scripts/registerCertificate.js TEST-CERT-001 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
```

If it succeeds, it will print a real `tx_hash` that opens on Sepolia Etherscan.

To verify:

```bash
node blockchain/scripts/verifyCertificate.js TEST-CERT-001 0xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
```

## Important notes

- Old certificates that have `tx_hash` beginning with `local-` were not recorded on-chain.
- For a real blockchain demo, issue a new certificate after configuring `.env` and deploying the included contract.
- If the Issue button returns an error saying `Only owner can register certificates`, the private key in `.env` is not the deployer/owner wallet.
- If the Issue button returns `No smart contract code found`, the contract address or network is wrong.
- If the Issue button returns an ABI/method error, redeploy `blockchain/contracts/CertificateRegistry.sol` and use its new address.
