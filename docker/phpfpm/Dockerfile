FROM php:7.4-fpm


RUN apt-get update \
    && apt-get install -y make \
    curl \
    unzip \
    libzip-dev \
    libicu-dev \
    git \
    && curl -sL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && npm install -g yarn \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install \
        pdo_mysql \
        zip \
        intl \
    && docker-php-ext-enable \
        opcache 
        
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /srv/app

CMD [ "php-fpm", "-F" ]
