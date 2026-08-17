# Docker Merge Notes

## Base application

The base for this merge is the newer CertChain version (the version with the real blockchain implementation). The following application areas were intentionally left unchanged:

- `app/`
- `blockchain/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `public/`

Docker was added around that application rather than copying application code from the older Docker branch.

## Added / changed for Docker

- Multi-stage `Dockerfile` with:
  - Composer production dependencies.
  - Vite frontend build.
  - production-only Node dependencies for runtime `ethers`.
  - PHP 8.4 FPM runtime.
  - nginx runtime target.
- `docker-compose.yml` with MySQL, migration, app, queue, and nginx services.
- `docker/php/certchain.ini` fixes upload limits and request execution limits.
- `docker/nginx/default.conf` handles Laravel routing, static assets, certificate upload size, and long blockchain request timeouts.
- `docker/entrypoint.sh` prepares Laravel writable storage and the public storage link.
- Persistent Docker volumes for MySQL and Laravel storage.
- Health checks for MySQL, PHP-FPM, and nginx.
- Automatic `php artisan migrate --force` before the application starts.
- `.dockerignore` to keep local secrets, dependencies, build artifacts, and uploaded certificate files out of Docker build layers.
- Docker-specific optional settings documented in `.env.example` and `DOCKER.md`.

## Important security decision

The downloadable merged archive intentionally does **not** include `.env`, because the current project `.env` contains real blockchain credentials/private-key material. Copy your existing `.env` from your working project into the merged folder before starting Docker.

## Validation performed

- Parsed `docker-compose.yml` successfully as YAML.
- Checked `docker/entrypoint.sh` shell syntax.
- Checked PHP syntax across the application/config/routes/database files.
- Checked nginx configuration syntax (with the Docker-only `app` hostname substituted during the local syntax test).
- Verified the real `BlockchainService`, `registerCertificate.js`, `verifyCertificate.js`, and `ethers` dependency remain present.
- Compared the application directories against the newer original and confirmed they were not replaced by the older Docker branch.

A Docker engine is not available in the analysis environment, so the final `docker compose up -d --build` runtime test must be performed on the target machine. Use the checks in `DOCKER.md` immediately after startup.

- The one-shot `migrate` service now runs migrations and the idempotent `DatabaseSeeder`, so a fresh Docker database always gets the default login account automatically.
