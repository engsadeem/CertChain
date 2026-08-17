# CertChain — Setup & Run

CertChain supports two run modes while using the **same MySQL database and shared certificate storage**.

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

## Environment

Create `.env` in the project root.

For Native Laravel:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=certchain
DB_USERNAME=certchain_user
DB_PASSWORD=YOUR_PASSWORD
```

Blockchain configuration:

```env
ETH_RPC_URL=
ETH_CONTRACT_ADDRESS=
ETH_PRIVATE_KEY=
```

> Never commit `.env` or private keys to GitHub.

---

# Option 1 — Full Docker

Build and start the complete project:

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

Stop:

```bash
docker compose down
```

---

# Option 2 — Native Laravel

Start only the shared MySQL database:

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

Run migrations:

```bash
php artisan migrate --seed
```

Create the storage link if needed:

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

Both modes use the same database:

```text
Docker Laravel → mysql:3306
Native Laravel → 127.0.0.1:3307
```

Certificates issued from either mode will appear in the same dashboard.
