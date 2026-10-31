# ============================================
# STAGE 1 : Base (common to both dev and prod)
# ============================================
FROM php:8.2-fpm AS base

RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]


# ============================================
# STAGE 2 : Tools (base + build utilities)
# ============================================
FROM base AS tools

RUN apt-get update && apt-get install -y git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ============================================
# STAGE 3 : Dev (local environment)
# ============================================
FROM tools AS dev

RUN { \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.revalidate_freq=0'; \
} > /usr/local/etc/php/conf.d/opcache-dev.ini


# ============================================
# STAGE 4 : Vendor (install PHP production packages)
# ============================================
FROM tools AS vendor

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev


# ============================================
# STAGE 5 : Assets (compile Vue / Vite front-end)
# ============================================
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

COPY . .
RUN npm run build


# ============================================
# STAGE 6 : Prod (final production server image)
# ============================================
FROM base AS prod

RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.validate_timestamps=0'; \
} > /usr/local/etc/php/conf.d/opcache-prod.ini

COPY --from=vendor /var/www /var/www
COPY --from=assets /app/public/build /var/www/public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data


# ============================================
# STAGE 7 : Nginx-prod (serveur web de production)
# ============================================
FROM nginx:alpine AS nginx-prod

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=prod /var/www/public /var/www/public
