FROM php:8.3-fpm-alpine

RUN apk update && apk upgrade
RUN apk add nginx curl bash libxml2-dev php-soap openssl-dev
RUN apk add --no-cache --virtual .build-deps pcre-dev $PHPIZE_DEPS
RUN apk add --update linux-headers
RUN pecl install redis xdebug ftp
RUN docker-php-ext-install soap pcntl ftp
RUN docker-php-ext-enable soap redis.so xdebug ftp
RUN docker-php-ext-configure ftp --with-openssl-dir=/usr
RUN apk del -f .build-deps

# Nginx config
RUN rm /etc/nginx/http.d/default.conf
COPY ./docker/default.conf /etc/nginx/http.d/
RUN rm /usr/local/etc/php-fpm.conf
COPY ./docker/php-fpm.conf /usr/local/etc/
COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/
COPY ./docker/docker-php-ram-limit.ini /usr/local/etc/php/conf.d
RUN mkdir /run/php

WORKDIR /var/task
COPY . /var/task

RUN chmod -R 0777 storage
RUN chmod -R 0777 bootstrap/cache

CMD php-fpm && nginx -g "daemon off;"
