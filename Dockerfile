FROM php:8.2-fpm-alpine

RUN apk update && apk upgrade
RUN apk add nginx curl bash libxml2-dev php-soap
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS
RUN pecl install redis
RUN docker-php-ext-install soap
RUN docker-php-ext-enable soap redis.so

# Nginx config
RUN rm /etc/nginx/http.d/default.conf
COPY ./docker/default.conf /etc/nginx/http.d/
RUN rm /usr/local/etc/php-fpm.conf
COPY ./docker/www.conf /usr/local/etc/php-fpm.conf
RUN mkdir /run/php

WORKDIR /usr/src/app
COPY . /usr/src/app

RUN chmod -R 0777 storage
RUN chmod -R 0777 bootstrap/cache

CMD php-fpm && nginx -g "daemon off;"
