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

# Keep runtime-only Laravel directories owned by PHP-FPM.
# storage/app/public is a host bind mount so native PHP and Docker share
# the exact same certificate/QR files; do not change the host owner.
chown -R www-data:www-data storage/framework storage/logs bootstrap/cache 2>/dev/null || true
chmod -R ug+rwX storage/framework storage/logs bootstrap/cache 2>/dev/null || true
chmod -R a+rwX storage/app/public 2>/dev/null || true

# The nginx image has the same public/storage link, while this link is needed
# by Laravel itself when it generates URLs or serves files from the app image.
php artisan storage:link >/dev/null 2>&1 || true

exec "$@"
