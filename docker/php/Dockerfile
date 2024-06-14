FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        curl \
        wget \
    && docker-php-ext-install \
        pdo_mysql \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN composer require symfony/console:"7.1.*"

WORKDIR /var/www