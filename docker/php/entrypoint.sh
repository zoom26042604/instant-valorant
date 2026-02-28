#!/bin/bash
set -e

cd /var/www/html

if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

exec php-fpm
