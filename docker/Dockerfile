FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

COPY php/php.ini /usr/local/etc/php/

WORKDIR /var/www/html

RUN mkdir /var/www/html/uploads

RUN chmod 755 /var/www/html/uploads

EXPOSE 9000