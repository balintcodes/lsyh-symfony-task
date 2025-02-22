FROM php:8.2-fpm

RUN apt-get update && apt-get install -y unzip git libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

WORKDIR /app

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader
RUN php bin/console doctrine:migrations:migrate

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
