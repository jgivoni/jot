#!/bin/bash

aws_access_key_id=$1
aws_access_key_secret=$2

# Making configuration changes to the environment after installation of components

usermod -a -G vagrant apache

# User home
rm -f /home/vagrant/.bashrc
ln -s /vagrant/provisioning/user/bashrc.sh /home/vagrant/.bashrc

# SELinux - relax restrictions to make it possible to serve files from other directory
setenforce 0

# Web app
ln -s /vagrant/provisioning/apache/jot.conf /etc/httpd/conf.d
rm /etc/httpd/conf.d/welcome.conf

ln -s /vagrant/provisioning/php/php.ini /etc/php.d/jot.ini

chmod -R 755 /jot

mkdir /var/lib/php/session
chmod -R 777 /var/lib/php/session

mkdir /var/data
mkdir /var/data/cache
chmod -R 777 /var/data

su - vagrant -c "cd /jot/app && composer install"

mkdir /home/vagrant/.aws
sed -e "s|<id>|$aws_access_key_id|g" -e "s|<secret>|$aws_access_key_secret|g" /vagrant/provisioning/aws/credentials.template > /home/vagrant/.aws/credentials
chown -R vagrant.vagrant /home/vagrant/.aws
chmod -R 750 /home/vagrant

# crons
ln -s /vagrant/provisioning/system/crons.txt /etc/cron.d/jot
chmod 755 /vagrant/provisioning/system/reboot.sh

# JOT CLI
ln -s /vagrant/provisioning/php/jotcli.php /usr/bin/jot
ln -s jot /usr/bin/jotadd
ln -s jot /usr/bin/jotget
ln -s jot /usr/bin/jotlink
ln -s jot /usr/bin/jotlist
ln -s jot /usr/bin/jottag
ln -s jot /usr/bin/jotupdate
ln -s jot /usr/bin/jotdelete
ln -s jot /usr/bin/jotunlink
ln -s jot /usr/bin/jotmove

ln -s /vagrant/provisioning/user/jotrc /home/vagrant/.jotrc

# Autostart services
systemctl start httpd
systemctl start php-fpm
systemctl enable httpd
systemctl enable php-fpm

systemctl start docker
systemctl enable docker

ntpdate pool.ntp.org
systemctl start ntpd.service
systemctl enable ntpd.service

# Redis
docker container run --name redis -d -p 6379:6379 --rm redis
