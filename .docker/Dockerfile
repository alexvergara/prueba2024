###############
FROM php:8.2-apache

COPY composer.json /var/www/html
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Update the image
RUN apt-get update \
    && apt-get install -y software-properties-common curl unzip default-mysql-client \
    && rm -rf /var/lib/{apt,dpkg,cache,log}

#RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install pdo pdo_mysql php-zip \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/download/2.7.2/composer.phar -o composer.phar \
    && mv composer.phar /usr/local/bin/composer && chmod 755 /usr/local/bin/composer

#RUN yes | pecl install xdebug \
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

#WORKDIR /var/www/html

#USER www-data

#RUN composer install
