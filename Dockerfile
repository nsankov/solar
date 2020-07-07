FROM php:7.3-apache
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install pdo pdo_mysql zip
COPY . /var/www/html
