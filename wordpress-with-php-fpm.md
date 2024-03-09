# Example of dockerfile for bedrock deployment

```Dockerfile
FROM node:21 as node

COPY ./web/app/themes/soilla-theme/package* /theme/soilla-theme/
RUN cd /theme/soilla-theme && npm install
COPY ./web/app/themes/soilla-theme /theme/soilla-theme
RUN cd /theme/soilla-theme && npm run build

FROM composer as composer
WORKDIR /wordpress
COPY ./composer* .
RUN composer install
COPY ./web/app/themes ./web/app/themes
COPY --from=node /theme/soilla-theme/public /theme/soilla-theme/public

FROM php:8.2-fpm
COPY --from=composer /wordpress /var/www/html/wordpress
WORKDIR  /var/www/html/wordpress
COPY ./config ./config
COPY ./web/*.php ./web/
RUN docker-php-ext-install mysqli pdo pdo_mysql sockets && docker-php-ext-enable mysqli
COPY ./php-fpm/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN addgroup --gid 900 --system app
RUN adduser --uid 900 --system --disabled-login --disabled-password --gid 900 app
RUN apt update && apt install -y nginx
RUN rm /etc/nginx/sites-enabled/default
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
RUN usermod -a -G app www-data
RUN chown -R app:app /var/www/html/wordpress/web/app
EXPOSE 80

CMD ["/bin/sh", "-c" ,"php-fpm -D && nginx -g 'daemon off;'"]
```

With following files:

`nginx/default.conf`:
```apacheconf
upstream php  {
    server unix:/var/run/php8.2-fpm.sock;
}

server {
    listen 80;
    server_name _;

    charset utf-8;
    index index.php index.html index.htm;
    root /var/www/html/wordpress/web;
    client_max_body_size 200M;
    include /etc/nginx/mime.types;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_intercept_errors on;
        fastcgi_pass php;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
    }

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;
}
```

`nginx/nginx.conf`:
```nginx
user app;
worker_processes auto;
include /etc/nginx/modules-enabled/*.conf;

pid /var/run/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    include /etc/nginx/conf.d/*.conf;
}
```

`php-fpm/www.conf`:
```toml
[global]
daemonize = no

[www]
listen = /var/run/php8.2-fpm.sock
user = app
group = app
pm = dynamic
pm.max_children = 5
pm.min_spare_servers = 1
pm.max_spare_servers = 3
listen.owner = app
listen.group = app
listen.mode = 0660
```

