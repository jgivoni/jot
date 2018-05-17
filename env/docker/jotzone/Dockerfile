# Jotzone image

FROM jotbase:latest

COPY provisioning /docker/provisioning

RUN /bin/bash /docker/provisioning/configuration.sh

COPY private/.aws-credentials /.aws/credentials
