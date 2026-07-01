# CertChainPro audit and run notes

## Fixes applied in this package

- Added missing `config/view.php` so Laravel view cache commands work on clean machines.
- Added the required runtime directories under `storage/framework`, `storage/logs`, and `bootstrap/cache`.
- Removed stale `public/hot`; Laravel will now use `public/build` unless Vite dev server is intentionally started.
- Added `.env.example` while keeping the current `.env` and current blockchain `ETH_*` linkage untouched.
- Added `PublicStorageController` and `/files/{path}` route for certificate PDFs and QR SVG files. This avoids Windows/Linux symlink problems when `php artisan storage:link` is unavailable.
- Updated the `Certificate::file_url` accessor and certificate details view to use the cross-platform file route.
- Added Linux and Windows helper setup scripts under `scripts/`.
- Added Node engine metadata matching the installed Vite/Laravel Vite toolchain.
- Rewrote `README.md` and added `RUN_PROJECT.md` with clean setup instructions.

## Blockchain status

The existing blockchain integration is still present:

- `config/blockchain.php`
- `app/Services/BlockchainService.php`
- `blockchain/scripts/hashPayload.js`
- `blockchain/scripts/registerCertificate.js`
- `blockchain/scripts/verifyCertificate.js`
- `blockchain/contracts/CertificateRegistry.sol`

No `ETH_*` value in `.env` was edited by this cleanup.

## Recommended local run

Use the detailed Arabic instructions in `RUN_PROJECT.md`.
