# Jotzone image

FROM centos:7

RUN yum install -y wget \
    httpd-2.4.6

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
    && rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

RUN yum install -y \
    php71w-fpm \
    php71w-opcache \
    php71w-cli \
    php71w-pdo \
    php71w-mysql \
    php71w-pecl-redis \
    php71w-mbstring \
    php71w-intl

RUN ln -sf /dev/stdout /var/log/httpd/access_log

COPY up.sh /usr/local/bin/

EXPOSE 80

CMD ["/bin/bash", "up.sh"]
