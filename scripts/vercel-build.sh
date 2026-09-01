#!/usr/bin/env bash
#
# Runs on every Vercel deployment, before the function is packaged.
#
# The database lives outside the deployment, so pushing code alone never
# changes what the shop displays. Migrating and seeding here keeps the two in
# step. Every seeder is idempotent and none deletes anything a customer
# created, so repeating this on each deploy is safe.
#
# It never fails the build: a deployment that cannot reach the database should
# still go out and show the connection notice rather than disappear behind a
# red build. It does say so loudly, because the first version of this script
# swallowed the failure and the database sat untouched for days.

set -uo pipefail

banner() { printf '\n%s\n' "────────────────────────────────────────────────────────────"; }

banner
echo "  Falak Store — deployment build"
banner

if ! command -v php > /dev/null 2>&1; then
    echo "!! php is not on PATH in the build image — skipping migrate/seed."
    echo "   Run it yourself:  php artisan falak:setup"
    exit 0
fi

if [ -z "${DB_PASSWORD:-}" ]; then
    echo "!! DB_PASSWORD is not set for this environment — skipping migrate/seed."
    echo "   Vercel → Settings → Environment Variables → add it for Production,"
    echo "   then redeploy. Nothing else here can work without it."
    exit 0
fi

# falak:setup prints the database it is about to touch, migrates, seeds, and
# reports the row counts — everything needed to read this log later.
ARGS=()
if [ -n "${ADMIN_EMAIL:-}" ] && [ -n "${ADMIN_PASSWORD:-}" ]; then
    ARGS+=(--admin="$ADMIN_EMAIL" --password="$ADMIN_PASSWORD")
elif [ -n "${ADMIN_EMAIL:-}" ]; then
    echo "!! ADMIN_EMAIL is set but ADMIN_PASSWORD is not — skipping the admin account."
fi

set +e
php artisan falak:setup "${ARGS[@]+"${ARGS[@]}"}" --no-interaction 2>&1 | grep -v -i 'password:'
status=${PIPESTATUS[0]}
set -e

if [ "$status" -ne 0 ]; then
    banner
    echo "  !! THE DATABASE WAS NOT UPDATED — the site will keep showing old data."
    echo "     The reason is printed above. The deployment itself continues."
    banner
else
    banner
    echo "  Database is up to date."
    banner
fi

exit 0
