ARG BUILDPLATFORM=linux/amd64
ARG PHP_VERSION=8.1

FROM --platform=${BUILDPLATFORM} php:${PHP_VERSION} as dev-tools

WORKDIR /src
RUN apt-get update -qqy && \
  apt-get -qqy install make git
RUN useradd -rm -s /bin/sh -u 1000 php
USER php

ENTRYPOINT ["/usr/bin/make"]
CMD [ "build" ]
