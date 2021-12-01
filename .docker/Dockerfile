FROM prestashop/prestashop:1.7.7.0-apache as common

FROM common as dev

RUN pecl install xdebug-2.9.8 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;

FROM common as prod

ENV DISPLAY_ERRORS="Off"
