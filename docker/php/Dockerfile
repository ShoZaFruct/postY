FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip \
    opcache \
    && docker-php-ext-enable opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY ./app /var/www/html
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html