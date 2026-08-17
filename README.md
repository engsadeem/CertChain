# CertChainPro

منصة Laravel لإصدار الشهادات الأكاديمية والتحقق منها عبر Ethereum Sepolia، مع حفظ بيانات الشهادة وملف PDF داخل MySQL/Laravel Storage وحفظ بصمة الشهادة على العقد الذكي.

## أهم ما في هذه النسخة

- إعدادات البلوك تشين الحالية داخل `.env` بقيت كما هي ولم يتم تغيير قيم `ETH_*`.
- تمت إضافة ملف `config/view.php` ومجلدات `storage` المطلوبة حتى لا يفشل `php artisan optimize:clear`.
- تمت إزالة `public/hot` حتى لا يحاول المشروع تحميل ملفات Vite من جهاز المطوّر القديم.
- تمت إضافة route آمن نسبيًا لعرض ملفات PDF و QR من `storage/app/public` حتى تعمل على Windows/Linux حتى لو فشل `storage:link`.
- تمت إضافة `.env.example` للتجهيز النظيف، مع بقاء `.env` الحالي موجودًا.
- تمت إضافة دليل تشغيل كامل في `RUN_PROJECT.md`.

## المتطلبات

- PHP 8.3 أو أحدث.
- Composer.
- Node.js 20.19 أو أحدث + npm 10 أو أحدث.
- MySQL أو MariaDB.

## التشغيل المختصر

اقرأ الملف:

```text
RUN_PROJECT.md
```

أوامر التشغيل الأساسية بعد تجهيز قاعدة البيانات:

```bash
composer install
npm install
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

بيانات Admin التجريبية بعد تشغيل seed:

```text
Email: test@example.com
Password: password
```

## ملاحظة أمان

ملف `.env` يحتوي إعدادات حساسة، خصوصًا `ETH_PRIVATE_KEY`. لا ترفعه على GitHub عام ولا ترسله إلا للفريق الموثوق بالمشروع.
