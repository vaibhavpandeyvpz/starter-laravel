ARG IMAGE_TAG=8.x-fpm

FROM ghcr.io/qrstuff/phackage:$IMAGE_TAG

ARG FPM_POOL=pool.prod.conf
ARG PHP_CONFIG=php.prod.ini

# install basic utilities
RUN apt-get update && \
    apt-get install -y nano vim wget

# install nginx
RUN apt-get update && \
    apt-get install -y nginx

# install crond & supervisord
RUN apt-get update && \
    apt-get install -y cron supervisor

# override php config
COPY .docker/$PHP_CONFIG /usr/local/etc/php/conf.d/99-overrides.ini

# override php-fpm pool
COPY .docker/$FPM_POOL /usr/local/etc/php-fpm.d/www.conf

# override supervisord config
COPY .docker/supervisor.conf /etc/supervisor/supervisord.conf

# override nginx vhost
COPY .docker/vhost.conf /etc/nginx/sites-available/default

# set consistent uid and gid
RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data && \
    usermod --shell /bin/bash www-data

# set working directory
WORKDIR /var/www/html

# install project deps
COPY composer.json .
COPY composer.lock .
COPY package.json .
COPY yarn.lock .

# install composer deps
RUN composer install --no-autoloader --no-dev --no-interaction --no-scripts

# install node.js deps
RUN yarn install --frozen-lockfile

# copy project files
COPY . .

# generate autoload files
RUN composer dump-autoload --optimize

# build production assets
RUN yarn build

# setup right permissions
RUN chgrp -R www-data bootstrap/cache storage && \
    chmod -R ug+rwx bootstrap/cache && \
    chmod -R ug+rw storage

# add cron
RUN echo "* * * * * www-data php /var/www/html/artisan schedule:run > /var/log/cron.log 2>&1" >> /etc/crontab

# run processes via supervisord
CMD ["sh", "-c", "supervisord -c /etc/supervisor/supervisord.conf --logfile /dev/null --pidfile /dev/null"]

# expose ports
EXPOSE 80
