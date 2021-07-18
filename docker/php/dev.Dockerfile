FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        git \
        zip \
        icu-dev \
        libzip-dev \
        postgresql-dev \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_pgsql \
        zip

RUN apk add --no-cache --virtual .xdebug-build-deps ${PHPIZE_DEPS} \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .xdebug-build-deps

ARG HOST_UID

RUN if [ ! -z "${HOST_UID}" ]; then \
        deluser www-data \
        && addgroup www-data \
        && adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
    fi

ENV WWW_DATA_UID ${HOST_UID}

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/php/symfony.pool.conf /usr/local/etc/php-fpm.d/

COPY docker/php/docker-entrypoint.sh /opt/docker-entrypoint.sh
RUN chmod +x /opt/docker-entrypoint.sh

ENTRYPOINT ["/opt/docker-entrypoint.sh"]