FROM php:7.4-apache

ENV PHP_VERSION=7.4.8
ENV APACHE_RUN_USER=daemon

COPY 01_pheature_flags.conf /etc/apache2/sites-available/01_pheature_flags.conf

RUN a2ensite 01_pheature_flags.conf
RUN a2enmod rewrite

COPY --from=mysql:8.0 /usr/bin/mysql /usr/local/bin/mysql

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

# Install packages
RUN apt-get update && apt-get install -y zip unzip

RUN docker-php-ext-install pdo_mysql

ENTRYPOINT ["docker-php-entrypoint"]

EXPOSE 80

CMD ["apache2-foreground"]
