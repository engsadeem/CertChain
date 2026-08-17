# CertChain Docker Guide

This Docker setup is built for the **current CertChain application**, including the real Laravel blockchain integration (`BlockchainService` + Node.js + `ethers` + Sepolia scripts).

## Architecture

- `nginx`: HTTP entry point on port `8080` by default.
- `app`: PHP 8.4 FPM + Laravel + Node.js runtime + production `ethers` dependency.
- `queue`: Laravel database queue worker.
- `migrate`: one-shot service that runs `php artisan migrate --force` before the app starts.
- `mysql`: MySQL 8.4 with a persistent named volume.
- `certchain_storage`: persistent Laravel storage volume for certificates, QR codes, sessions, cache, and logs.

## 1. Environment

Use the project's existing `.env`. For a fresh copy:

```bash
cp .env.example .env
```

Set at least:

```env
APP_KEY=...
ETH_RPC_URL=
ETH_CONTRACT_ADDRESS=...
ETH_PRIVATE_KEY=
```

The Docker stack overrides `DB_HOST` to `mysql`, so the same `.env` can still keep `DB_HOST=127.0.0.1` for native/local execution.

Optional Docker-only values:

```env
DOCKER_APP_PORT=8080
DOCKER_APP_URL=http://localhost:8080
MYSQL_ROOT_PASSWORD=
```

Do not commit or share `.env` when it contains a real private key.

## 2. Build and start

```bash
docker compose up -d --build
```

The `migrate` service runs the database migrations automatically before `app` and `queue` start.

Check status:

```bash
docker compose ps
```

Open:

```text
http://localhost:8080
```

## 3. Fresh database demo user (optional)

The existing `DatabaseSeeder` creates the project's test admin account. Run it only when you want demo data:

```bash
docker compose exec app php artisan db:seed --force
```

## 4. Verify the important runtime requirements

PHP upload limits (must show 12M / 16M):

```bash
docker compose exec app php -r 'echo "upload=".ini_get("upload_max_filesize").PHP_EOL."post=".ini_get("post_max_size").PHP_EOL;'
```

Node.js runtime:

```bash
docker compose exec app node --version
```

`ethers` runtime dependency:

```bash
docker compose exec app node -e "import('ethers').then(m => console.log('ethers', m.version))"
```

Blockchain configuration (does not print secrets):

```bash
docker compose exec app php artisan tinker --execute="dump(app(App\\Services\\BlockchainService::class)->isConfigured());"
```

## 5. Logs

```bash
docker compose logs -f nginx app queue mysql
```

For certificate-issue problems, start with:

```bash
docker compose logs -f app nginx
```

## 6. Rebuild after source changes

This is an image-based setup, not a bind-mounted development setup. After changing PHP/Blade/JS code:

```bash
docker compose up -d --build
```

## 7. Stop / reset

Stop containers while preserving certificates and database data:

```bash
docker compose down
```

Delete **all Docker database and storage data** and start completely fresh:

```bash
docker compose down -v
```

Be careful: `-v` deletes the Docker MySQL data and uploaded certificates/QR codes stored in the Docker volumes.

## 8. Existing native project data

Docker uses its own MySQL and storage volumes. Your existing host MySQL database is not automatically copied into Docker.

If you want a clean Docker demo, migrations + optional seeding are enough. If you need to migrate the existing native database/certificates, back them up first and import/copy them deliberately rather than mixing the host DB with the container DB.

## Notes specific to CertChain

- The application allows certificate PDFs up to 10 MiB. Docker config sets PHP to `upload_max_filesize=12M`, `post_max_size=16M`, and nginx to `client_max_body_size=16M`.
- `BlockchainService` launches Node scripts during normal HTTP requests. Therefore Node.js and the production `ethers` package are intentionally present in the final PHP image.
- Blockchain registration can wait up to 300 seconds. nginx/PHP timeouts are configured above that limit so nginx does not prematurely return a 504 while the Sepolia transaction is still being confirmed.
- Only nginx is published to the host. PHP-FPM and MySQL remain on the internal Docker network.
