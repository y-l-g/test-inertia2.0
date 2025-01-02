#!/bin/sh
set -e

for secret_file in /run/secrets/*; do
    name=$(basename $secret_file | sed "s/^${APP_NAME}_//")
    value=$(cat $secret_file)
    sed -i "s|^${name}=.*|${name}=${value}|" /app/.env
done

php /app/artisan storage:link
php /app/artisan optimize
# rm /app/.env

exec "$@"
