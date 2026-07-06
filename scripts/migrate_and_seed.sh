#!/usr/bin/env bash
set -euo pipefail

# Safe migration + seed script
# Usage:
#   APP_ENV=production FORCE=true ./scripts/migrate_and_seed.sh

APP_ENV=${APP_ENV:-$(php -r "echo getenv('APP_ENV') ?: 'local';")}
FORCE=${FORCE:-false}

echo "Detected APP_ENV=$APP_ENV"

if [[ "$APP_ENV" == "production" && "$FORCE" != "true" ]]; then
  echo "Refusing to run migrations in production without FORCE=true"
  echo "If you intend to run in production, re-run with: APP_ENV=production FORCE=true $0"
  exit 1
fi

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --class=DatabaseSeeder

echo "Migrations and seeders completed."
