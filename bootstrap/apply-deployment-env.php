<?php

/**
 * Applies this deployment's environment before the framework boots.
 *
 * Loaded by every entry point — the web function and the console — because
 * `php artisan migrate` during a deployment build has to reach the same
 * database the site does. It previously ran only from api/index.php, so
 * build-time artisan fell back to the framework's defaults (MySQL on
 * localhost), failed to connect, and left the database untouched while the
 * deployment reported success.
 *
 * A .env file wins outright: in development that file is the authority, and
 * these values must never override it.
 */

if (file_exists(__DIR__.'/../.env')) {
    return;
}

$defaults = [
    // The Lambda filesystem is read-only apart from /tmp.
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_DRIVER' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'LOG_CHANNEL' => 'stderr',
];

// Non-secret connection coordinates; the password comes from the host.
$defaults += require __DIR__.'/deployment-env.php';

foreach ($defaults as $key => $value) {
    $current = getenv($key);

    if ($current === false || $current === '') {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Blade does not create its compiled-view directory itself.
$viewsPath = getenv('VIEW_COMPILED_PATH');

if ($viewsPath && ! is_dir($viewsPath)) {
    @mkdir($viewsPath, 0755, true);
}
