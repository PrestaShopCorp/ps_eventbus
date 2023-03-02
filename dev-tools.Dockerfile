ARG BUILDPLATFORM=linux/amd64
ARG PHP_VERSION=8.2

FROM --platform=${BUILDPLATFORM} php:${PHP_VERSION}-alpine as dev-tools

WORKDIR /src

# See https://xdebug.org/docs/compat and https://xdebug.org/docs/install and https://xdebug.org/download/historical
ENV PCRE_DEV="autoconf g++ linux-headers"
RUN apk add -U make $PCRE_DEV && \
  case $PHP_VERSION in \
  7.1*) export XDEBUG_VERSION="2.9.8";; \
  7*) export XDEBUG_VERSION="3.1.6";; \
  *) export XDEBUG_VERSION="3.2.0";; \
  esac; \
  pecl channel-update pecl.php.net && \ 
  pecl install xdebug-${XDEBUG_VERSION} && \
  docker-php-ext-enable xdebug && \
  apk del $PCRE_DEV;

RUN adduser -H -D -s /bin/sh -u 1000 php
USER php

ENTRYPOINT ["/usr/bin/make"]
CMD [ "build" ]
