FROM wordpress:latest

RUN apt update && apt install -y \
    wget \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN wget https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -O /usr/local/bin/wp && \
    chmod +x /usr/local/bin/wp

RUN echo '\
    file_uploads = On \n\
    upload_max_filesize = 3G \n\
    post_max_size = 3G \n\
    memory_limit = 256M \n\
    max_execution_time = 600 \n\
    ' > /usr/local/etc/php/conf.d/uploads.ini

EXPOSE 80

RUN wp core download --path=/var/www/html  --allow-root
RUN wp config create --dbname=$WORDPRESS_DB_NAME --dbuser=$WORDPRESS_DB_USER --dbpass=$WORDPRESS_DB_PASSWORD --dbhost=mysql  --allow-root
RUN wp core install --url=http://localhost:8000 --title=Wordpress --admin_user=admin --admin_password=admin --admin_email=admin@test.com  --allow-root