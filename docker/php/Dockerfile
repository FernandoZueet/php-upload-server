FROM php:7.3-apache

RUN apt-get update & apt-get install -y 

#composer
RUN apt-get update 
RUN apt-get install -y git zip unzip zlib1g-dev libzip-dev 
RUN apt-get -y autoremove & apt-get clean & rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN docker-php-ext-install zip pcntl bcmath
RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

#xdebug
RUN pecl install xdebug-2.9.4 && docker-php-ext-enable xdebug 
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini