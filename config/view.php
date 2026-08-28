<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | The active theme is searched first, so a theme may override any core
    | view, with the shared views as the fallback.
    |
    */

    'paths' => [
        resource_path('views/themes/'.env('APP_THEME', 'xylo')),
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | Where compiled Blade templates are written. This has to stay
    | env-configurable: on a read-only host (serverless) the app points it at a
    | writable directory such as /tmp/views. realpath() only normalises an
    | existing directory and returns false when it is missing, so fall back to
    | the plain path rather than letting false through.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views')) ?: storage_path('framework/views')
    ),

];
