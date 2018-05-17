#!/bin/bash

# Making configuration changes to the environment after installation of components

# Web app
ln -s /docker/provisioning/apache/jot.conf /etc/httpd/conf.d
rm /etc/httpd/conf.d/welcome.conf

ln -s /docker/provisioning/php/php.ini /etc/php.d/jot.ini

mkdir /var/lib/php/session
chmod -R 777 /var/lib/php/session

mkdir /var/data
mkdir /var/data/cache
chmod -R 777 /var/data

mkdir /.aws
