<?php

/**
 * Vercel serverless entry point.
 *
 * The Lambda filesystem is read-only apart from /tmp, so every path Laravel
 * writes to is redirected there before the framework boots. These are only
 * defaults — anything already set in the Vercel project environment wins.
 */
$serverlessDefaults = [
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

foreach ($serverlessDefaults as $key => $value) {
    $current = getenv($key);

    if ($current === false || $current === '') {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Blade does not create the compiled-view directory itself.
$viewsPath = getenv('VIEW_COMPILED_PATH');

if ($viewsPath && ! is_dir($viewsPath)) {
    @mkdir($viewsPath, 0755, true);
}

require __DIR__.'/../public/index.php';
