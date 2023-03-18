FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade
RUN apk add nginx curl bash libxml2-dev php-soap
RUN docker-php-ext-install soap
RUN docker-php-ext-enable soap

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
