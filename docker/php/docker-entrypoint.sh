#!/usr/bin/env sh

COMMAND="composer install --prefer-dist --no-progress --no-interaction"

if [[ "true" != "${XDEBUG_ENABLED}" ]]; then
    rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
fi

if [[ "prod" = "${APP_ENV}" ]]; then
    COMMAND="${COMMAND} --no-dev --optimize-autoloader --classmap-authoritative"
fi

if [[ ! -z "${WWW_DATA_UID}" ]]; then
    su \
        -c "${COMMAND}" \
        -s /bin/sh \
        -m \
        www-data
else
    ${COMMAND}
fi

chown -R www-data var/ vendor/

bin/console doctrine:migrations:migrate --no-interaction

php-fpm