#!/bin/bash
# Things that need to happen after reboot
docker container run --name redis -d -p 6379:6379 --rm redis
systemctl start httpd
