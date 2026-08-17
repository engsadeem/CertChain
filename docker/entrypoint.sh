#!/usr/bin/env sh
set -eu

cd /var/www/html

mkdir -p \
  storage/app/public/certificates \
  storage/app/public/qrcodes \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

chown -R www-data:www-data storage/framework storage/logs bootstrap/cache 2>/dev/null || true
chmod -R ug+rwX storage/framework storage/logs bootstrap/cache 2>/dev/null || true
chmod -R a+rwX storage/app/public 2>/dev/null || true
php artisan storage:link >/dev/null 2>&1 || true

exec "$@"
