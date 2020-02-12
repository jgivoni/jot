#!/usr/bin/env bash

cd "$(dirname "$0")"

docker build ../../../app -f Dockerfile.source -t jotappsrc

docker build \
  -t jotbase \
  .
