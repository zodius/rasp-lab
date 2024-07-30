FROM alpine:latest

RUN apk --no-cache add \
        php83 \
        php83-ctype \
        php83-curl \
        php83-dom \
        php83-exif \
        php83-fileinfo \
        php83-fpm \
        php83-gd \
        php83-iconv \
        php83-intl \
        php83-json \
        php83-mbstring \
        php83-mysqli \
        php83-opcache \
        php83-openssl \
        php83-pecl-apcu \
        php83-pdo \
        php83-pdo_mysql \
        php83-pgsql \
        php83-phar \
        php83-session \
        php83-simplexml \
        php83-soap \
        php83-sodium \
        php83-tokenizer \
        php83-xml \
        php83-xmlreader \
        php83-zip \
        php83-zlib \
        nginx \
        runit \
        curl \
    && rm -rf /var/cache/apk/* \
    && rm /etc/nginx/http.d/default.conf \
    && chown -R nobody:nobody /run \
    && chown -R nobody:nobody /var/lib/nginx \
    && chown -R nobody:nobody /var/log/nginx

COPY --chown=nobody rootfs/ /
USER nobody
WORKDIR /var/www/html
EXPOSE 8080
ENTRYPOINT ["/bin/docker-entrypoint.sh"]

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://localhost:8080/fpm-ping || exit 1
