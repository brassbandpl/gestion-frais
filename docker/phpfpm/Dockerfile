FROM php:7.3-fpm


RUN apt-get update \
    && apt-get install -y make \
    curl \
    nodejs \
    npm \
    unzip \
    libzip-dev \
    git \
    && npm install -g npm@latest \
    && npm install -g yarn \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /srv/app

CMD [ "php-fpm", "-F" ]
