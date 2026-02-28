FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000