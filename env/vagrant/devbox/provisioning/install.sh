#!/bin/bash

# Installing all components

# wget
yum install -y wget

# Apache
yum install -y httpd-2.4.6

# Add webtatic repos (for php7)
rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

# PHP
yum install -y php71w-fpm
yum install -y php71w-opcache
yum install -y php71w-cli
yum install -y php71w-pdo
yum install -y php71w-mysql
yum install -y php71w-pecl-redis
yum install -y php71w-mbstring
yum install -y php71w-intl

# NTP - time update
yum install -y ntp

# MySQL client
yum install -y mariadb-5.5.52

# AWS CLI
curl -O https://bootstrap.pypa.io/get-pip.py
python get-pip.py
pip install awscli --upgrade

# Composer
/bin/bash /vagrant/provisioning/composer.sh

# Docker
yum install -y yum-utils \
  device-mapper-persistent-data \
  lvm2
sudo yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo
yum-config-manager --enable docker-ce-edge
yum install -y docker-ce
