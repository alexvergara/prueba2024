###############
FROM php:8.2-apache

# Copy the composer files
COPY composer.* /var/www/html

# Copy the vhost configuration
COPY .docker/web/vhost.conf /etc/apache2/sites-available/000-default.conf

# Update the image and install the required packages
RUN apt-get update \
    && apt-get install -y software-properties-common curl unzip default-mysql-client \
    && rm -rf /var/lib/{apt,dpkg,cache,log}

# Install the required PHP extensions and enable the Apache modules
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/download/2.7.2/composer.phar -o composer.phar \
    && mv composer.phar /usr/local/bin/composer && chmod 755 /usr/local/bin/composer

# Set the user to default
USER 1000

# Install the PHP dependencies
RUN cd /var/www/html && /usr/local/bin/composer install
