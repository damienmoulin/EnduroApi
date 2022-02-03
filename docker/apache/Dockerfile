FROM php:7.4.25-apache

RUN \
    # url rewriting
    a2enmod rewrite

# postgres and mssql drivers
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql
