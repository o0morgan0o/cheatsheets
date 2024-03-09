# Basic server) Basic Server

```bash
php -S 127.0.0.1:8000
```

# Dockerfile

```Dockerfile
FROM php:8.2.0-fpm-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli
# RUN docker-php-ext-install nd_mysqli pdo pdo_mysql && docker-php-ext-enable nd_mysqli
```
