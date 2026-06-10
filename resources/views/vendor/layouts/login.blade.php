<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('css')

    <style>
        /* Global Font - Poppins for English, Cairo for Arabic */
        body, h1, h2, h3, h4, h5, h6, p, span, div,
        .btn, .form-control, .form-label, input, textarea, select, a {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        /* Arabic font override */
        [dir="rtl"] body, [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3,
        [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6, [dir="rtl"] p,
        [dir="rtl"] span, [dir="rtl"] div, [dir="rtl"] .btn,
        [dir="rtl"] .form-control, [dir="rtl"] .form-label,
        [dir="rtl"] input, [dir="rtl"] textarea, [dir="rtl"] select, [dir="rtl"] a {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
</head>
<body>

    @yield('content')

    @yield('js')
</body>
</html>
