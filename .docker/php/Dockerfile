FROM php:7.4-fpm

RUN apt update \
    && apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt update \
    && apt install -y libzip-dev zlib1g-dev \
    && docker-php-ext-install -j$(nproc) zip

RUN docker-php-ext-install exif && docker-php-ext-enable exif

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

RUN pecl install redis-5.3.4 && docker-php-ext-enable redis

RUN pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && php -r "unlink('composer-setup.php');"
