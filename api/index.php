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

    echo <<<'HTML'
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>إعداد غير مكتمل</title>
<style>
  body { margin:0; background:#0f1216; color:#e8e6e1; font-family:Tahoma,"Segoe UI",system-ui,sans-serif; line-height:1.9; }
  .box { max-width:640px; margin:8vh auto; padding:32px 28px; background:#181d23; border:1px solid #2a3138; border-radius:12px; }
  h1 { margin:0 0 6px; font-size:22px; }
  p  { color:#a6aeb8; margin:0 0 18px; }
  ol { padding-inline-start:20px; margin:0; }
  li { margin-bottom:10px; }
  code { direction:ltr; unicode-bidi:embed; background:#0f1216; border:1px solid #2a3138;
         border-radius:5px; padding:2px 7px; font-family:ui-monospace,Menlo,Consolas,monospace; font-size:13px; }
  .en { margin-top:22px; padding-top:16px; border-top:1px solid #2a3138; direction:ltr; text-align:left;
        color:#8f98a3; font-size:13px; }
</style>
</head>
<body>
  <div class="box">
    <h1>الموقع غير مُهيّأ بعد</h1>
    <p>ينقص متغيّر البيئة <code>APP_KEY</code>، وبدونه لا يمكن للتطبيق أن يعمل.</p>
    <ol>
      <li>ولّد مفتاحاً: <code>php artisan key:generate --show</code></li>
      <li>أضفه في إعدادات المشروع لدى مزوّد الاستضافة باسم <code>APP_KEY</code> (تأكد من تفعيله لبيئة Production).</li>
      <li>أعد النشر — إضافة المتغيّر وحدها لا تكفي.</li>
    </ol>
    <div class="en">
      <strong>Setup incomplete.</strong> The <code>APP_KEY</code> environment variable is missing.
      Generate one with <code>php artisan key:generate --show</code>, add it to the project's
      environment variables for Production, then redeploy.
    </div>
  </div>
</body>
</html>
HTML;

    exit;
}

require __DIR__.'/../public/index.php';
