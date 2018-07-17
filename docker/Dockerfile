FROM ubuntu:18.04

RUN apt-get update && \
    apt-get -y install php-fpm \
    php-common \
    php-cli \
    php7.2-xml \
    php-mysql \
    php-mbstring \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir /run/php/ \
    && ln -s /usr/sbin/php-fpm7.2 /usr/local/bin/php-fpm

WORKDIR /srv/app
EXPOSE 8000

COPY init.sh /srv/init.sh

#RUN docker-php-ext-install -j$(nproc) pcntl

CMD /srv/init.sh
