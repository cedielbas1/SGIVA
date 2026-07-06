#!/usr/bin/env bash
set -euo pipefail

php artisan config:clear
php artisan optimize:clear

if [ -z "${APP_KEY:-}" ] || [ "$APP_KEY" = "base64:YOU_NEED_TO_RUN_PHP_ARTISAN_KEY_GENERATE" ]; then
  php artisan key:generate --force
fi

if [ -n "${DATABASE_URL:-}" ] || [ -n "${DB_HOST:-}" ] || [ -n "${MYSQLHOST:-}" ]; then
  php artisan migrate --force
  php artisan db:seed --force
fi

exec "$@"
