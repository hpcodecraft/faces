FROM php:5.4-apache

RUN a2enmod headers \
  && a2enmod rewrite \
  && a2enmod authz_groupfile \
  && docker-php-ext-install mysql \
  && service apache2 restart

COPY src/ /var/www/html/