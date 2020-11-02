FROM richarvey/nginx-php-fpm:1.5.7

RUN apk add --no-cache --virtual .build-deps \
    g++ make autoconf yaml-dev

RUN pecl channel-update pecl.php.net

RUN apk update

RUN pecl install apcu  \
  && docker-php-ext-enable apcu \
  && docker-php-ext-install gd bcmath sockets

RUN apk update && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev openldap-dev postgresql-dev && \
    docker-php-ext-install ldap pgsql pdo_pgsql && \
    apk del .build-deps && \
    rm -rf /tmp/* /var/cache/apk/*

RUN wget https://getcomposer.org/installer -O composer-setup.php \
  && php ./composer-setup.php  --quiet --version=1.10.16 --install-dir=/usr/local/bin \
  && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer \
  && composer global require hirak/prestissimo

ENV SKIP_CHOWN=true

COPY . /var/www/html
WORKDIR /var/www/html

ENV RUN_SCRIPTS=1
ENV SKIP_COMPOSER=true


RUN cd /var/www/html \
    && composer install --no-scripts -n \
    && composer clearcache -n \
    && bin/console assets:install



