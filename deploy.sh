#!/usr/bin/env bash
# =============================================================================
#  Run on the Hostinger server (SSH) from the project folder (public_html):
#      bash deploy.sh
#  Safe to run after every git pull. Creates .env on the first run.
# =============================================================================
set -e
cd "$(dirname "$0")"

PHP=${PHP:-php}

# 1. .env on first deploy
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env from .env.example — edit MAIL_PASSWORD etc. afterwards."
fi

# 2. app key (only if empty)
if ! grep -qE '^APP_KEY=base64:' .env; then
    $PHP artisan key:generate --force
fi

# 3. writable folders
mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 4. dependencies (vendor/ is committed; this only runs if composer exists)
if command -v composer >/dev/null 2>&1; then
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# 5. production caches
$PHP artisan optimize:clear
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

echo "Deploy finished."
