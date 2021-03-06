#!/bin/bash
# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
        . /etc/bashrc
fi

# Uncomment the following line if you don't like systemctl's auto-paging feature:
# export SYSTEMD_PAGER=

# User specific aliases and functions
alias flush="sudo docker container exec -it redis redis-cli flushall"
alias reload="source /home/vagrant/.bashrc"
alias start="sudo /vagrant/provisioning/system/reboot.sh"

export LANG=en_US.UTF-8

sudo setenforce 0
