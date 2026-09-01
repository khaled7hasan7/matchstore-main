#!/usr/bin/env bash
#
# Brings Falak Store up on this machine, from a fresh clone, in one command.
#
# Uses SQLite so there is no database server to install, configure or start —
# the file lives in database/database.sqlite and can be deleted to start over.
# Nothing here touches Supabase or the deployed site.

set -uo pipefail
cd "$(dirname "$0")/.."

say()  { printf '\n\033[1m%s\033[0m\n' "$*"; }
fail() { printf '\n\033[31m✗ %s\033[0m\n' "$*"; exit 1; }

say "Falak Store — local setup"

# ---------------------------------------------------------------- php
command -v php > /dev/null 2>&1 || fail "PHP is not installed. Install PHP 8.1 or newer, then run this again."

PHP_OK=$(php -r 'echo PHP_VERSION_ID >= 80100 ? "yes" : "no";')
[ "$PHP_OK" = "yes" ] || fail "PHP $(php -r 'echo PHP_VERSION;') is too old — 8.1 or newer is required."

MISSING=""
for ext in pdo_sqlite mbstring openssl fileinfo curl; do
    php -m | grep -qi "^${ext}$" || MISSING="$MISSING $ext"
done
[ -z "$MISSING" ] || fail "PHP is missing these extensions:$MISSING
  On Windows: open php.ini and remove the ';' in front of the matching extension= lines.
  On Ubuntu:  sudo apt install php-sqlite3 php-mbstring php-curl php-xml
  On macOS:   brew install php"

echo "  PHP $(php -r 'echo PHP_VERSION;') ✓"

# ---------------------------------------------------------------- dependencies
if [ ! -f vendor/autoload.php ]; then
    say "Installing dependencies (first run only)"
    if command -v composer > /dev/null 2>&1; then
        composer install --no-interaction --prefer-dist || fail "composer install failed."
    elif [ -f composer.phar ]; then
        php composer.phar install --no-interaction --prefer-dist || fail "composer install failed."
    else
        fail "Composer is not installed. Get it from https://getcomposer.org, then run this again."
    fi
else
    echo "  dependencies ✓"
fi

# ---------------------------------------------------------------- environment
if [ ! -f .env ]; then
    say "Creating .env"
    cat > .env <<'ENV'
APP_NAME="Falak Store"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

# SQLite: a single file, no server to install or start.
DB_CONNECTION=sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Emails are written to storage/logs/laravel.log instead of being sent.
MAIL_MAILER=log
MAIL_FROM_ADDRESS="orders@falakstore.local"
MAIL_FROM_NAME="${APP_NAME}"
ENV
    echo "  .env created (SQLite)"
else
    echo "  .env ✓ (kept as it is)"
fi

grep -q '^APP_KEY=base64:' .env || { say "Generating the application key"; php artisan key:generate --force; }

# ---------------------------------------------------------------- database
DB_DRIVER=$(php -r '$l=@file("./.env")?:[]; foreach($l as $x){ if(preg_match("/^DB_CONNECTION=(.*)$/",trim($x),$m)) echo trim($m[1]); }')
if [ "${DB_DRIVER:-sqlite}" = "sqlite" ] && [ ! -f database/database.sqlite ]; then
    say "Creating the database file"
    mkdir -p database && touch database/database.sqlite
    echo "  database/database.sqlite ✓"
fi

mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache
php artisan config:clear --quiet 2>/dev/null
php artisan view:clear --quiet 2>/dev/null

# ---------------------------------------------------------------- the store
ADMIN_MAIL="${ADMIN_EMAIL:-admin@falakstore.local}"
ADMIN_PASS="${ADMIN_PASSWORD:-falak12345}"

say "Building the store"
php artisan falak:setup --admin="$ADMIN_MAIL" --password="$ADMIN_PASS" --no-interaction \
    || fail "Setting up the store failed — the reason is printed above."

cat <<INFO

────────────────────────────────────────────────────────────
  Falak Store is ready.

  Storefront   http://127.0.0.1:8000
  Dashboard    http://127.0.0.1:8000/admin/login
  Email        $ADMIN_MAIL
  Password     $ADMIN_PASS

  Stop the server with Ctrl+C. Run this script again any time —
  it never deletes products, orders or anything a customer made.
────────────────────────────────────────────────────────────

INFO

php artisan serve --host=127.0.0.1 --port=8000
