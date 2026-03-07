FROM php:8.3-fpm-alpine

RUN apk update && apk upgrade

RUN apk add --no-cache \
    nginx \
    curl \
    bash \
    libxml2-dev \
    openssl-dev \
    linux-headers

RUN apk add --no-cache --virtual .build-deps \
    pcre-dev \
    $PHPIZE_DEPS

RUN pecl install redis xdebug \
    && docker-php-ext-install soap pcntl ftp \
    && docker-php-ext-enable redis xdebug \
    && apk del -f .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Nginx config
RUN rm /etc/nginx/http.d/default.conf
COPY ./docker/default.conf /etc/nginx/http.d/

RUN rm /usr/local/etc/php-fpm.conf
COPY ./docker/php-fpm.conf /usr/local/etc/

COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/
COPY ./docker/docker-php-ram-limit.ini /usr/local/etc/php/conf.d/

RUN mkdir /run/php

WORKDIR /var/task
COPY . /var/task

RUN chmod -R 0777 storage
RUN chmod -R 0777 bootstrap/cache

CMD php-fpm && nginx -g "daemon off;"