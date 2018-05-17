#!/usr/bin/env bash

echo "Starting php and apache"

mkfifo /var/log/php-fpm/www-error.log
tail -f /var/log/php-fpm/www-error.log &

php-fpm -DO

rm -f /var/run/httpd/httpd.pid
exec httpd -DFOREGROUND
