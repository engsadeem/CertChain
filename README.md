# CertChain — Project Setup & Run

The project supports **two execution modes** while using the same canonical MySQL database and the same certificate storage.

## Architecture

Both modes use the same database:

```text
Full Docker:
Browser → Nginx → Laravel Container → MySQL Container

Native Mode:
Browser → php artisan serve → MySQL Container
```

Database access:

```text
Inside Docker:
mysql:3306

From the host / Native Laravel:
127.0.0.1:3307
```

This ensures that certificates, students, proof records, and dashboard data remain consistent regardless of how the application is started.

---

# Prerequisites

Make sure the following are installed:

```text
Docker
Docker Compose
```

For Native Mode, also install:

```text
PHP
Composer
Node.js
npm
```

---

# Environment Configuration

Create or obtain the `.env` file and place it in the project root.

For Native Laravel, the database configuration should be:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=certchain
DB_USERNAME=certchain_user
DB_PASSWORD=YOUR_DATABASE_PASSWORD
```

Docker automatically overrides the database host and port internally to:

```text
DB_HOST=mysql
DB_PORT=3306
```

Blockchain configuration must also be available in `.env`:

```env
ETH_RPC_URL=
ETH_CONTRACT_ADDRESS=
ETH_PRIVATE_KEY=
```

Do not commit `.env` or private blockchain keys to GitHub.

---

# Method 1 — Full Docker

This is the recommended and easiest way to run the entire project.

## 1. Open the project

```bash
cd CertChainPro
```

## 2. Start and build the project

```bash
docker compose up -d --build
```

Docker will automatically start:

```text
MySQL
Laravel PHP-FPM
Nginx
Queue Worker
Database migrations
Database seeders
```

## 3. Check container status

```bash
docker compose ps
```

Expected services:

```text
mysql     healthy
app       healthy
queue     running
nginx     healthy
```

The `migrate` container may appear as `Exited (0)` after startup. This is normal because it runs migrations and seeders once and then exits.

## 4. Open the application

```text
http://localhost:8080
```

## Stop the project

```bash
docker compose down
```

Do not normally use:

```bash
docker compose down -v
```

because `-v` deletes Docker volumes, including the persistent MySQL database.

---

# Method 2 — Native Laravel + Shared Docker MySQL

This mode runs Laravel, PHP, Composer, and Node.js directly on the host machine while using the same MySQL database used by the Docker version.

This preserves the **Single Source of Truth**.

## 1. Open the project

```bash
cd CertChainPro
```

## 2. Start only the shared MySQL database

```bash
docker compose up -d mysql
```

Verify that it is running:

```bash
docker compose ps mysql
```

The database should be available to the host on:

```text
127.0.0.1:3307
```

## 3. Install PHP dependencies

```bash
composer install
```

## 4. Install Node.js dependencies

```bash
npm ci
```

## 5. Generate the application key if required

Only run this if `APP_KEY` is empty in `.env`:

```bash
php artisan key:generate
```

Do not regenerate the key every time the project is started.

## 6. Clear Laravel caches

```bash
php artisan optimize:clear
```

## 7. Run database migrations and seeders

```bash
php artisan migrate --seed
```

This is safe to run against the shared database. Existing migrations will not be executed again.

## 8. Create the storage link

```bash
php artisan storage:link
```

If the link already exists, this step can be skipped.

## 9. Build frontend assets

```bash
npm run build
```

## 10. Start Laravel

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Open:

```text
http://127.0.0.1:8000
```

---

# Single Source of Truth

Both execution modes use the same canonical database.

```text
                         MySQL Container
                       ┌─────────────────┐
                       │    certchain    │
                       │                 │
                       │ Docker: 3306    │
                       │ Host:   3307    │
                       └────────┬────────┘
                                │
                 ┌──────────────┴──────────────┐
                 │                             │
                 ▼                             ▼
        Native Laravel                   Docker Laravel
      php artisan serve                 Nginx + PHP-FPM
```

Therefore:

```text
Certificate issued from Native Laravel
                ↓
Appears in Docker Dashboard

Certificate issued from Docker
                ↓
Appears in Native Laravel Dashboard
```

The same applies to:

```text
Students
Certificates
Blockchain Proof Records
Verification Logs
Dashboard statistics
PDF certificates
QR codes
```

---

# Important

Do not start a separate local MariaDB/MySQL database on port `3306` for this project.

Do not use:

```bash
sudo systemctl start mariadb
sudo mysql
```

to create another `certchain` database.

Doing so would create a second database and break the Single Source of Truth architecture.

For Native Mode, always start the shared database using:

```bash
docker compose up -d mysql
```

---

# Useful Commands

Check all containers:

```bash
docker compose ps
```

View logs:

```bash
docker compose logs -f
```

View Laravel container logs:

```bash
docker compose logs -f app
```

View Nginx logs:

```bash
docker compose logs -f nginx
```

View MySQL logs:

```bash
docker compose logs -f mysql
```

Restart the full Docker environment:

```bash
docker compose restart
```

Verify the shared database from Native Laravel:

```bash
php artisan tinker --execute="dump(App\Models\Certificate::count());"
```

Verify the same database from Docker:

```bash
docker compose exec -T app php artisan tinker --execute="dump(App\Models\Certificate::count());"
```

Both commands should return the same certificate count.
