#!/usr/bin/env bash
#
# Runs on every Vercel deployment, before the function is packaged.
#
# The database lives outside the deployment, so pushing code alone never
# changes what the shop displays — that was the whole reason "nothing
# updates" after a deploy. Migrating and seeding here keeps the two in step.
#
# Every seeder is idempotent and none of them deletes anything a customer
# created, so running this on each deploy is safe. It also never fails the
# build: a deploy that cannot reach the database should still go out and
# show the connection notice, not disappear behind a red build.

set -uo pipefail

echo "── Falak Store build ──────────────────────────────────────────"

if ! command -v php > /dev/null 2>&1; then
    echo "!! php not found in the build image — skipping migrate/seed."
    echo "   Run them yourself:  php artisan migrate --force && php artisan db:seed --force"
    exit 0
fi

php -r 'exit(0);' || { echo "!! php present but not runnable — skipping."; exit 0; }

if [ -z "${DB_PASSWORD:-}" ]; then
    echo "!! DB_PASSWORD is not set for this environment — skipping migrate/seed."
    echo "   Add it in Vercel → Settings → Environment Variables, then redeploy."
    exit 0
fi

echo "→ migrating"
php artisan migrate --force --no-interaction 2>&1 | tail -20

echo "→ seeding"
php artisan db:seed --force --no-interaction 2>&1 | tail -30

# The dashboard needs an account, and there is no other moment in a
# serverless deployment to create one. Both variables must be set; the
# password is never generated here so it cannot end up in a build log.
if [ -n "${ADMIN_EMAIL:-}" ] && [ -n "${ADMIN_PASSWORD:-}" ]; then
    echo "→ administrator account"
    php artisan admin:create "$ADMIN_EMAIL" --password="$ADMIN_PASSWORD" --no-interaction 2>&1 \
        | grep -v -i password
fi

echo "── build done ─────────────────────────────────────────────────"
exit 0
