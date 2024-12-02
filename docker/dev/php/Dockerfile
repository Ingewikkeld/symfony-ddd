FROM php:8.2-fpm-alpine AS base

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    coreutils \
    freetype-dev \
    libjpeg-turbo-dev \
    libjpeg-turbo \
    libpng-dev \
    libzip-dev \
    jpeg-dev \
    zlib-dev \
    curl-dev \
    icu-dev \
    icu-data-full \
    gettext-dev \
    git \
    zip \
    unzip \
    libpq-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install opcache pdo_pgsql intl calendar gd
RUN docker-php-ext-enable opcache

RUN rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY docker/dev/php/php.ini /usr/local/etc/php/conf.d/php.override.ini
COPY docker/dev/php/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /app

CMD ["php-fpm", "--nodaemonize"]

FROM base AS dev

FROM base AS prod

ENV APP_ENV prod

RUN chown www-data:www-data /app
COPY --chown=www-data:www-data . /app

RUN composer install --no-dev
