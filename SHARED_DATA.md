# Shared CertChain data (native PHP + Docker)

The dashboard is database-backed. The smart contract only stores a `bytes32` fingerprint and timestamp, so it cannot reconstruct student names, degrees, PDF paths, or the original human-readable certificate ID.

This build therefore uses one canonical MySQL database for both runtimes and one shared host directory for uploaded certificates/QR codes.

## Canonical database

Docker MySQL is exposed only on localhost port `3307`.

- Docker Laravel uses `mysql:3306` internally.
- Native Laravel should use `127.0.0.1:3307`.

After the one-time merge, set in `.env`:

```env
DB_HOST=127.0.0.1
DB_PORT=3307
DOCKER_DB_PORT=3307
```

When running Laravel natively, keep only the database service running:

```bash
docker compose up -d mysql
php artisan serve
```

When running everything in Docker:

```bash
docker compose up -d
```

Both modes then read/write the same `certchain_mysql_data` volume.

## One-time merge of the old native database into Docker

Before changing `DB_PORT` in `.env`, start the updated Docker stack. The old native database is assumed to still be on `127.0.0.1:3306`, while Docker MySQL is exposed on `127.0.0.1:3307`.

```bash
docker compose up -d --build
php scripts/merge-local-db-into-docker.php --source-port=3306 --dest-port=3307
```

The merge is transactional and writes JSON backups of both relevant datasets under `storage/app/backups/` before changing the Docker database. Existing certificates are matched by `certificate_id` and their blockchain proof must agree; a conflict aborts the merge instead of overwriting data.

Then change `.env` to `DB_PORT=3307` and run:

```bash
php artisan optimize:clear
docker compose up -d --force-recreate
```

## One-time copy of certificate/QR files from the previous Docker named volume

The new build bind-mounts `./storage/app/public`, so native PHP and Docker see the same PDFs and QR files. If the old Docker setup already issued certificates, copy the old named-volume public files into the project directory once.

With the current project containers running, get the runtime storage volume name:

```bash
VOL=$(docker inspect "$(docker compose ps -q app)" --format '{{range .Mounts}}{{if eq .Destination "/var/www/html/storage"}}{{.Name}}{{end}}{{end}}')
```

Then merge its public files into the project storage without deleting existing native files:

```bash
docker run --rm -v "$VOL:/from:ro" -v "$PWD/storage/app/public:/to" alpine sh -lc 'mkdir -p /to/certificates /to/qrcodes; cp -a /from/app/public/. /to/'
```

After this one-time copy, new uploads from either runtime go directly to the same `storage/app/public` directory.
