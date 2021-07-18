FROM nginx:alpine

WORKDIR /etc/nginx

ARG HOST_UID

RUN if [ ! -z "${HOST_UID}" ]; then \
        adduser -u "${HOST_UID}" -G www-data -H -s /bin/sh -D www-data; \
    fi

ENV PHP_UPSTREAM=localhost:9000

RUN rm ./conf.d/default.conf

COPY docker/nginx/nginx.conf .
COPY docker/nginx/server.conf ./sites-available/server.conf

COPY docker/nginx/docker-entrypoint.sh /opt/docker-entrypoint.sh
RUN chmod +x /opt/docker-entrypoint.sh

ENTRYPOINT ["/opt/docker-entrypoint.sh"]