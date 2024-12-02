FROM nginx:stable-alpine AS base

COPY docker/dev/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/dev/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/dev/nginx/app_ssl.crt /etc/ssl/certs/app_ssl.crt
COPY docker/dev/nginx/app_ssl.key /etc/ssl/private/app_ssl.key
RUN mkdir -p /app/public

FROM base AS dev

FROM base AS prod

COPY public /app/public
RUN rm /app/public/index.php # Not needed in nginx, php-fpm will handle this
