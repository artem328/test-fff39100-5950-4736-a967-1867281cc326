#!/usr/bin/env sh

echo "upstream php-upstream { server ${PHP_UPSTREAM}; }" > ./conf.d/upstream.conf

nginx -g "daemon off;"
