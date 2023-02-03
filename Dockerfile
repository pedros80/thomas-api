FROM bref/extra-redis-php-81 as redisextra
FROM bref/php-81-fpm-dev
COPY --from=redisextra /opt /opt
