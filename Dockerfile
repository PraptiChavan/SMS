FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate

RUN php artisan storage:link

EXPOSE 10000

# CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
CMD php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000