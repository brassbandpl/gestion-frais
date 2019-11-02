FROM ubuntu:18.04

RUN apt-get update && \
    apt-get -y install php-fpm \
    php-common \
    php-cli \
    php7.2-xml \
    php-mysql \
    php-mbstring \
    php-zip \
    curl \
    && apt install -y git \
    && apt install -y nodejs npm \
    && npm install -g npm@latest \
    && npm install -g yarn \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir /run/php/ \
    && ln -s /usr/sbin/php-fpm7.2 /usr/local/bin/php-fpm \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /srv/app
EXPOSE 8000

COPY init.sh /srv/init.sh

CMD /srv/init.sh
