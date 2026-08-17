# syntax=docker/dockerfile:1

# ------------------------------------------------------------
# 1) PHP dependencies (production only)
# ------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .
RUN composer dump-autoload \
    --no-dev \
    --classmap-authoritative \
    --no-interaction \
    --no-scripts

# ------------------------------------------------------------
# 2) Front-end build
# ------------------------------------------------------------
FROM node:24-bookworm-slim AS frontend
WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ------------------------------------------------------------
# 3) Runtime Node dependencies
# The Laravel BlockchainService executes Node scripts at runtime,
# so ethers must remain available in the final PHP image.
# ------------------------------------------------------------
FROM node:24-bookworm-slim AS node-runtime
WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci --omit=dev \
    && npm cache clean --force

# ------------------------------------------------------------
# 4) Laravel / PHP-FPM runtime
# ------------------------------------------------------------
FROM php:8.4-fpm-bookworm AS app
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        libonig-dev \
        libstdc++6 \
        libzip-dev \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
        pcntl \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP settings used by certificate uploads / blockchain requests.
COPY docker/php/certchain.ini /usr/local/etc/php/conf.d/99-certchain.ini

# Node is required at runtime by app/Services/BlockchainService.php.
COPY --from=node-runtime /usr/local/bin/node /usr/local/bin/node
COPY --from=node-runtime /app/node_modules ./node_modules

# Application source + built dependencies/assets.
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p \
        storage/app/public/certificates \
        storage/app/public/qrcodes \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/certchain-entrypoint
RUN chmod +x /usr/local/bin/certchain-entrypoint

ENTRYPOINT ["certchain-entrypoint"]
CMD ["php-fpm"]

# ------------------------------------------------------------
# 5) nginx runtime
# Uses the same Vite build stage as the PHP image, avoiding a second
# independent frontend build definition.
# ------------------------------------------------------------
FROM nginx:1.27-alpine AS nginx
WORKDIR /var/www/html

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY public ./public
COPY --from=frontend /app/public/build ./public/build

# Uploaded certificates / QR codes live in the shared storage volume.
RUN mkdir -p storage/app/public \
    && rm -rf public/storage \
    && ln -s ../storage/app/public public/storage
