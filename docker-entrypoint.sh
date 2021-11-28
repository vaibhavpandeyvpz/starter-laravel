#!/bin/sh
set -e

mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs

php artisan package:discover --ansi
php artisan optimize

chgrp -R www-data bootstrap/cache storage
chmod -R ug+rwx bootstrap/cache storage

# https://github.com/docker-library/php/blob/master/7.4/buster/apache/docker-php-entrypoint
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

exec "$@"
