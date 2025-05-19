FROM php:8.2-cli

RUN apt-get update && apt-get install -y unzip libpq-dev postgresql-client && \
    docker-php-ext-install pdo pdo_pgsql && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

COPY start.sh /usr/src/myapp/start.sh
RUN chmod +x /usr/src/myapp/start.sh

CMD ["/usr/src/myapp/start.sh"]
