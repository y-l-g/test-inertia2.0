FROM dunglas/frankenphp

RUN set -eux; \
    apt-get update \
    && apt-get install -y --no-install-recommends\
    procps \
    acl \
    nano \
    file \
    gettext \
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

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
