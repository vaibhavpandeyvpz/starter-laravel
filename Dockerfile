# syntax=docker/dockerfile:1

FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

RUN apt-get update && \
    apt-get install -y libzip-dev && \
    docker-php-ext-install -j$(nproc) zip

RUN docker-php-ext-install bcmath exif pdo_mysql

RUN pecl install redis && docker-php-ext-enable redis

RUN apt-get update && \
    apt-get install -y git
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN composer install --no-interaction --prefer-dist

RUN sed -ri -e "s@/var/www/html@/var/www/html/public@g" /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite headers

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["apache2-foreground"]
