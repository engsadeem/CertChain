# تشغيل CertChainPro على Linux و Windows

> ملاحظة مهمة: لم يتم تغيير إعدادات البلوك تشين الموجودة في ملف `.env`. القيم الحالية بقيت كما هي. لا ترفع ملف `.env` على GitHub عام لأنه يحتوي مفاتيح خاصة.

## المتطلبات

- PHP 8.3 أو أحدث مع الإضافات: `mbstring`, `openssl`, `pdo_mysql`, `fileinfo`, `tokenizer`, `ctype`, `xml`.
- Composer.
- Node.js 20.19 أو أحدث، و npm 10 أو أحدث.
- MySQL أو MariaDB.

## بيانات قاعدة البيانات الافتراضية في `.env`

```env
DB_DATABASE=certchain
DB_USERNAME=certchain_user
DB_PASSWORD=CertChain@12345
```

## تشغيل سريع على Linux

```bash
cd CertChainPro
sudo systemctl start mariadb 2>/dev/null || sudo systemctl start mysql
sudo mysql
```

داخل MySQL/MariaDB شغّل:

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

بعدها:

```bash
composer install
npm install
mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/logs storage/app/public/certificates storage/app/public/qrcodes bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache
php artisan key:generate --force
php artisan optimize:clear
php artisan migrate --seed
php artisan storage:link || true
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

افتح:

```text
http://127.0.0.1:8000
```

حساب Admin التجريبي بعد `db:seed`:

```text
Email: test@example.com
Password: password
```

## تشغيل سريع على Windows / Laragon

1. شغّل Laragon وتأكد أن MySQL يعمل.
2. افتح Terminal داخل مجلد المشروع.
3. أنشئ قاعدة البيانات والمستخدم:

```powershell
mysql -u root -p
```

ثم داخل MySQL:

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

4. شغّل أوامر المشروع:

```powershell
composer install
npm install
New-Item -ItemType Directory -Force storage/framework/views, storage/framework/cache/data, storage/framework/sessions, storage/logs, storage/app/public/certificates, storage/app/public/qrcodes, bootstrap/cache
php artisan key:generate --force
php artisan optimize:clear
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

افتح:

```text
http://127.0.0.1:8000
```

## ملاحظات مهمة

- لا تحتاج تشغيل `npm run dev` للتسليم العادي؛ تم بناء ملفات الواجهة داخل `public/build`.
- لو أردت تعديل CSS/JS أثناء التطوير فقط، افتح Terminal ثاني وشغّل:

```bash
npm run dev
```

- إذا لم يعمل `php artisan storage:link` على Windows، سيبقى عرض ملفات PDF و QR يعمل من خلال route جاهز داخل المشروع: `/files/...`.
- لإعادة ضبط الكاش بعد أي تعديل في `.env`:

```bash
php artisan optimize:clear
```

- ربط Sepolia الحالي يعتمد على قيم `ETH_*` الموجودة في `.env`. لم يتم تغييرها.
