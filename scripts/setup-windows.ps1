$ErrorActionPreference = 'Stop'
Set-Location (Join-Path $PSScriptRoot '..')

$dirs = @(
  'storage/framework/views',
  'storage/framework/cache/data',
  'storage/framework/sessions',
  'storage/logs',
  'storage/app/public/certificates',
  'storage/app/public/qrcodes',
  'bootstrap/cache'
)
foreach ($dir in $dirs) { New-Item -ItemType Directory -Force -Path $dir | Out-Null }

if (-not (Test-Path '.env')) {
  Copy-Item '.env.example' '.env'
  Write-Host 'Created .env from .env.example. Fill DB and blockchain values before issuing certificates.'
}

composer install
npm install
php artisan key:generate --force
php artisan optimize:clear
try { php artisan storage:link } catch { Write-Host 'storage:link skipped; /files route will still serve PDFs and QR codes.' }
npm run build

Write-Host 'Setup finished. Create/import the database, then run: php artisan migrate --seed'
