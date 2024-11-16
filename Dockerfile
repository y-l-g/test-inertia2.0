FROM dunglas/frankenphp:1.3.1-php8.3-bookworm

RUN set -eux; \
    apt-get update \
    && apt-get install -y --no-install-recommends\
    procps \
    acl \
    nano \
    file \
    gettext \
    nodejs \
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



