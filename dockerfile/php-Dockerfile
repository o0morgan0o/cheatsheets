FROM php:8.2

RUN apt update -y \
    && apt install -y \
    && apt autoremove -y \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt install curl -y \
    && apt install git -y \
    && apt install zip -y \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html/

RUN composer install

EXPOSE 8000

ENTRYPOINT ["symfony", "server:start", "--no-tls", "--port=8000"]

