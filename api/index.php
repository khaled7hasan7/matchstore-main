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

// Without an encryption key Laravel cannot boot, and the resulting stack
// trace tells the operator nothing. Show the actual fix instead. Skipped when
// a .env file exists (local use), so this only ever fires on a host.
$appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? $_SERVER['APP_KEY'] ?? '');

if (trim((string) $appKey) === '' && ! file_exists(__DIR__.'/../.env')) {
    http_response_code(503);
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store');
    header('Retry-After: 3600');

    $notice = require __DIR__.'/../bootstrap/setup-notice.php';

    echo $notice(
        'الموقع غير مُهيّأ بعد',
        'ينقص متغيّر البيئة <code>APP_KEY</code>، وبدونه لا يمكن للتطبيق أن يعمل.',
        [
            'ولّد مفتاحاً: <code>php artisan key:generate --show</code>',
            'أضفه في متغيّرات بيئة المشروع باسم <code>APP_KEY</code> مع تفعيله لبيئة Production.',
            'أعد النشر — إضافة المتغيّر وحدها لا تكفي.',
        ],
        '<strong>Setup incomplete.</strong> The <code>APP_KEY</code> environment variable is missing. '
        .'Generate one with <code>php artisan key:generate --show</code>, add it to the project\'s '
        .'environment variables for Production, then redeploy.'
    );

    exit;
}

require __DIR__.'/../public/index.php';
