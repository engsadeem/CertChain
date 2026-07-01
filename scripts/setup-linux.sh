#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."

mkdir -p storage/framework/{views,cache/data,sessions} storage/logs storage/app/public/{certificates,qrcodes} bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache || true

if [ ! -f .env ]; then
  cp .env.example .env
  echo "Created .env from .env.example. Fill DB and blockchain values before issuing certificates."
fi

composer install
npm install
php artisan key:generate --force
php artisan optimize:clear
php artisan storage:link || true
npm run build

echo "Setup finished. Create/import the database, then run: php artisan migrate --seed"
