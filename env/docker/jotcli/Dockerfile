# Jot CLI image

FROM php:7.1-cli

RUN pecl install redis && \
    docker-php-ext-enable redis

COPY bootstrap.php .

RUN ln -s /bootstrap.php /usr/bin/jot && \
    ln -s jot /usr/bin/jotadd && \
    ln -s jot /usr/bin/jotget && \
    ln -s jot /usr/bin/jotlink && \
    ln -s jot /usr/bin/jotlist && \
    ln -s jot /usr/bin/jottag && \
    ln -s jot /usr/bin/jotupdate && \
    ln -s jot /usr/bin/jotdelete && \
    ln -s jot /usr/bin/jotunlink && \
    ln -s jot /usr/bin/jotmove
