FROM prestashop/prestashop:1.7.7.0-apache as common

FROM common as dev

RUN pecl install xdebug \ && docker-php-ext-enable xdebug;

FROM common as prod

ENV DISPLAY_ERRORS="Off"
