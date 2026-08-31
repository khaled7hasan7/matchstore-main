<?php

/**
 * Non-secret deployment defaults, applied by api/index.php before the
 * framework boots and only when the host has not already set them — so any
 * value configured in the hosting dashboard still wins.
 *
 * These are connection coordinates, not credentials: they identify which
 * database to talk to and are the same values Supabase prints in its Connect
 * dialog. The password is deliberately NOT here and must be supplied as a
 * DB_PASSWORD environment variable on the host; without it the connection is
 * refused, so this file grants no access on its own.
 *
 * @return array<string, string>
 */
return [
    'DB_CONNECTION' => 'pgsql',
    'DB_HOST' => 'aws-0-eu-central-1.pooler.supabase.com',
    'DB_PORT' => '5432',
    'DB_DATABASE' => 'postgres',
    'DB_USERNAME' => 'postgres.sdnkvokzbslziodmwhoa',
    'DB_SSLMODE' => 'require',
];
