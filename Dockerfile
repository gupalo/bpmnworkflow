FROM php:8.1-fpm

# Permission fix
RUN usermod -u 1000 www-data

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY . /code
WORKDIR /code
