# Base PHP image with needed extensions
FROM php:8.2-cli-bookworm AS php-base
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    postgresql-client-15 \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
FROM php-base AS php-deps
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# Build frontend assets
FROM node:20 AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# Final runtime image
FROM php-base AS production
WORKDIR /var/www/html

COPY --from=php-deps /var/www/html /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

RUN chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8000

EXPOSE 8000

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}"]
