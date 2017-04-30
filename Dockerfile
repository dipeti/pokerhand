FROM php:7.1.4-apache
COPY . /var/www/html
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip
RUN sed -i 's/\/var\/www\/html/\/var\/www\/html\/web/	' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN chown www-data:www-data -R /var/www/html
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN php composer.phar install

RUN ./vendor/phpunit/phpunit/phpunit


