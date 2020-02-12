# Jotzone image
FROM jotbase:latest as dev
COPY vhost.conf /etc/httpd/conf.d/
COPY php.ini /etc/php.d/php.ini
RUN mkdir /jot
COPY bootstrap.php /jot/bootstrap.php

FROM dev
COPY --from=jotappsrc /app /jot/app
