# CertChain — Setup & Run

CertChain supports two run modes while using the **same MySQL database and shared certificate storage**.

The required `.env` file is provided separately with the project team.

## Requirements

### Docker Mode

```text
Docker
Docker Compose
```

### Native Mode

```text
PHP
Composer
Node.js
npm
Docker
Docker Compose
```

---

# Option 1 — Full Docker

Start the complete project:

```bash
docker compose up -d --build
```

Check services:

```bash
docker compose ps
```

Open:

```text
http://localhost:8080
```

Stop the project:

```bash
docker compose down
```

---

# Option 2 — Native Laravel

Start the shared MySQL database:

```bash
docker compose up -d mysql
```

Install dependencies:

```bash
composer install
npm ci
```

Clear Laravel cache:

```bash
php artisan optimize:clear
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Create the storage link:

```bash
php artisan storage:link
```

Build frontend assets:

```bash
npm run build
```

Start Laravel:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Open:

```text
http://127.0.0.1:8000
```

---

## Shared Database

Both modes use the same MySQL database:

```text
Docker Laravel → mysql:3306
Native Laravel → 127.0.0.1:3307
```

Certificates and proof records created from either mode will appear in the same dashboard.
