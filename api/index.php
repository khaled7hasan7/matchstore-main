<?php

/**
 * Vercel serverless entry point.
 *
 * The Lambda filesystem is read-only except /tmp, so the compiled-views
 * directory must exist before Laravel boots (VIEW_COMPILED_PATH and the
 * APP_*_CACHE paths are pointed at /tmp in vercel.json).
 */
$viewsPath = $_ENV['VIEW_COMPILED_PATH'] ?? '/tmp/views';

if (! is_dir($viewsPath)) {
    mkdir($viewsPath, 0755, true);
}

require __DIR__.'/../public/index.php';
