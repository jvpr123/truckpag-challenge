FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libcurl4-openssl-dev \
    libssl-dev \
    pkg-config \
    libpng-dev \
    && docker-php-ext-install pdo && docker-php-ext-install bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
