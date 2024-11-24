FROM dunglas/frankenphp:1.3.1-php8.3-bookworm AS common

RUN set -eux; \
    apt-get update \
    && apt-get install -y --no-install-recommends\
    cron \
    procps \
    acl \
    nano \
    file \
    gettext \
    nodejs \
    npm \
    git \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    install-php-extensions \
    @composer \
    gd \
    imap \
    xml \
    mbstring \
    readline \
    soap \
    bcmath \
    curl \
    ldap \
    pcntl \
    igbinary \
    msgpack \
    pcov \
    pdo_mysql \
    memcached \
    redis \
    opcache \
    intl \
    zip

RUN echo "* * * * * root /usr/local/bin/php /app/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/schedule
RUN chmod 0644 /etc/cron.d/schedule

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"
COPY <<EOT $PHP_INI_DIR/app.conf.d/php.ini
    realpath_cache_size = 4096K
    realpath_cache_ttl = 600
    opcache.enable=1
    opcache.enable_cli=1
    opcache.interned_strings_buffer = 16
    opcache.max_accelerated_files = 20000
    opcache.memory_consumption = 256
    opcache.enable_file_override = 1
EOT

WORKDIR /app
COPY --link . .

#####################################################
# CADDY-REVERSE-PROXY
#####################################################

FROM caddy:2.8 AS caddy-reverse-proxy

COPY --link ./Caddyfile /etc/caddy/Caddyfile

RUN apk add --update curl && \
    rm -rf /var/cache/apk/*

