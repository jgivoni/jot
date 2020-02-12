#!/usr/bin/env bash
# Ensure you're logged in:
#(aws ecr get-login --no-include-email --region eu-west-1 --profile jgadmin)

cd "$(dirname "$0")"

docker build \
  -t 447633916892.dkr.ecr.eu-west-1.amazonaws.com/jotzone-app-php \
  .

docker push 447633916892.dkr.ecr.eu-west-1.amazonaws.com/jotzone-app-php
