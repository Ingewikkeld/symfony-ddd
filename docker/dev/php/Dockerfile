FROM php:8.2-apache AS base

# CLI dependencies
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP Extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions \
        # symfony requirements
        ctype \
        iconv \
        json \
        session \
        tokenizer \
        xml \
        # other \
        calendar \
        curl \
        gd \
        intl \
        opcache \
        pdo_pgsql \
        zip

COPY --from=composer/composer:latest-bin /composer /usr/local/bin/composer
COPY docker/dev/php/php.ini /usr/local/etc/php/conf.d/php.override.ini

# Enable required Apache modules
RUN a2enmod headers rewrite

# Link public folder to /var/www/html to use default virtualhost configuration
RUN rm -rf /var/www/html && \
    ln -s /app/public /var/www/html

WORKDIR /app
VOLUME ["/app"]

FROM base AS dev

FROM base AS prod

ENV APP_ENV prod

RUN chown www-data:www-data /app
COPY --chown=www-data:www-data . /app

RUN composer install --no-dev
