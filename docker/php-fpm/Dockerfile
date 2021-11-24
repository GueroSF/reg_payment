FROM php:7.4-fpm-alpine

ARG user
ARG uid

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN set -xe && \
    apk add --update icu libuv && \
    apk add --no-cache autoconf && \
    apk add --virtual .build-deps --no-cache --update \
        file g++ gcc libc-dev make bash pkgconf re2c zlib-dev icu-dev && \
    apk add --upgrade gnu-libiconv && \
    apk add --no-cache python3 py3-pip && \
    apk add --update nghttp2-dev nodejs npm libuv && \
    apk add --update git curl fish && \
    pecl install xdebug && \
    docker-php-ext-configure intl && \
    docker-php-ext-install sockets iconv opcache intl bcmath pdo pdo_mysql && \
    docker-php-ext-enable sockets xdebug intl bcmath && \
    { find /usr/local/lib -type f -print0 | xargs -0r strip --strip-all -p 2>/dev/null || true; }

RUN apk del -f .build-deps && \
    rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/*

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN addgroup -S $user -g $uid && adduser -S $user -u $uid -G $user -h /home/$user
RUN mkdir -p /home/$user/.composer && \
    mkdir -p /home/$user/.ssh && \
    chown -R $user:$user /home/$user

WORKDIR /app

USER $user
