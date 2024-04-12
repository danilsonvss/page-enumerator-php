# Use a imagem PHP como base
FROM php:latest

RUN apt-get update \
    && apt-get install -y libzip-dev zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/html

RUN mkdir files \
    && chmod -R 777 files

COPY ./*.php .
COPY php.ini /usr/local/etc/php/php.ini


EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]
