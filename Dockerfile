# Build dependencies (PHP Composer)
FROM composer:2 AS vendor
WORKDIR /app

# Install PHP dependencies early for caching
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --optimize-autoloader

# Bring in the full application and re-run to pick up autoload info
COPY . ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --optimize-autoloader

# Build front-end assets
FROM node:20 AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# Runtime image
FROM php:8.2-fpm-bullseye
WORKDIR /var/www/html

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
    && docker-php-ext-install pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application code & assets from build stages
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

# Ensure storage paths are writable at runtime
RUN chown -R www-data:www-data storage bootstrap/cache

ENV PORT=8000 \
    APP_ENV=production \
    APP_DEBUG=false
EXPOSE 8000

# Render will run this container and expects a long-running process.
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}"]
