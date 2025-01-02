###########################################
# FrankenPHP
###########################################

FROM dunglas/frankenphp:1.3

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN set -eux; \
    apt-get update \
    && apt-get install -y --no-install-recommends\
    acl \
    cron \
    file \
    gettext \
    procps \
    nodejs \
    npm \
    && apt-get clean

RUN set -eux; \
    install-php-extensions \
    @composer \
    pcntl \
    pdo_mysql \
    redis \
    opcache \
    intl \
    zip

#####################################################

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

#####################################################

WORKDIR /app

COPY --link composer.json composer.lock ./

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    # --no-dev \
    --no-interaction \
    --no-autoloader \
    --no-ansi \
    --no-scripts

COPY --link package.json package-lock.json ./

RUN npm ci

COPY --link --chmod=755 start-container.sh /usr/local/bin/start-container

COPY --link . .

RUN npm run build

RUN composer dump-autoload \
    # --no-dev \
    --classmap-authoritative \
    --optimize \
    --no-ansi \
    && composer clear-cache

#####################################################

RUN echo "* * * * * root /usr/local/bin/php /app/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/schedule
RUN chmod 0644 /etc/cron.d/schedule

