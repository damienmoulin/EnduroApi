FROM php:7.4.25-apache
ARG USERID=1000

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    # for composer
    # git for bundle satis
    && apt-get -y install zip unzip git

# postgres and mssql drivers
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql

# fix: composer cache directory not writable
ENV COMPOSER_HOME /tmp
# fix: psalm cache directory not writable
ENV XDG_CACHE_HOME /tmp

WORKDIR /app

# fix: files permission
RUN usermod -u $USERID www-data
USER www-data