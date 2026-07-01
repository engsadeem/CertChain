# Final Project

## Project Setup & Run

### 1. Open the project folder

```bash
cd CertChainPro
```

### 2. Start the database service

```bash
sudo systemctl start mariadb 2>/dev/null || sudo systemctl start mysql
```

### 3. Open MySQL

```bash
sudo mysql
```

### 4. Create database and user

```sql
CREATE DATABASE IF NOT EXISTS certchain CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'certchain_user'@'localhost' IDENTIFIED BY 'CertChain@12345';
CREATE USER IF NOT EXISTS 'certchain_user'@'127.0.0.1' IDENTIFIED BY 'CertChain@12345';

ALTER USER 'certchain_user'@'localhost' IDENTIFIED BY 'CertChain@12345';
ALTER USER 'certchain_user'@'127.0.0.1' IDENTIFIED BY 'CertChain@12345';

GRANT ALL PRIVILEGES ON certchain.* TO 'certchain_user'@'localhost';
GRANT ALL PRIVILEGES ON certchain.* TO 'certchain_user'@'127.0.0.1';

FLUSH PRIVILEGES;

EXIT;
```

### 5. Install dependencies

```bash
composer install
npm install
```

### 6. Generate application key

```bash
php artisan key:generate --force
```

### 7. Clear cache and optimize

```bash
php artisan optimize:clear
```

### 8. Run database migrations and seeders

```bash
php artisan migrate --seed
```

### 9. Create storage link

```bash
php artisan storage:link || true
```

### 10. Build frontend assets

```bash
npm run build
```

### 11. Run the project

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Open the project in your browser:

```text
http://127.0.0.1:8000
```

## Demo Login

```text
Email: test@example.com
Password: password
```
