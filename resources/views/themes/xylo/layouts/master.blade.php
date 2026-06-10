<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'fa', 'he']) ? 'rtl' : 'ltr' }}" @if(in_array(app()->getLocale(), ['ar', 'fa', 'he'])) style="font-family: 'Cairo', sans-serif !important;" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic Page Title from Site Settings --}}
    <title>@yield('title', $siteSettings->site_name ?? config('app.name', 'Store'))</title>

    {{-- Meta Description and Keywords from Site Settings --}}
    @if($siteSettings)
        @if($siteSettings->meta_description)
        <meta name="description" content="{{ $siteSettings->meta_description }}">
        @endif
        @if($siteSettings->meta_keywords)
        <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
        @endif
    @endif

    {{-- Favicon from Site Settings --}}
    @if($siteSettings && $siteSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    {{-- Google Fonts - Poppins for English, Cairo for Arabic --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Flag Icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">

    @if (!App::environment('testing'))
        @vite(['resources/views/themes/xylo/sass/app.scss'])
    @endif
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @if (!App::environment('testing'))
            @vite(['resources/views/themes/xylo/css/animate.min.css'])
        @endif
        @if (!App::environment('testing'))
            @vite(['resources/views/themes/xylo/css/slick.css'])
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
        @if (!App::environment('testing'))
            @vite(['resources/views/themes/xylo/css/style.css'])
        @endif
        @if (!App::environment('testing'))
            @vite(['resources/views/themes/xylo/css/custom.css'])
        @endif
    @yield('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    {{-- Dynamic Theme CSS Variables --}}
    <style id="dynamic-theme-vars">
        :root {
            {!! getThemeCssVariables() !!}
        }
    </style>

    {{-- Global Compact Styling --}}
    <style>
        /* Global Font - Poppins for English, Cairo for Arabic - FORCE OVERRIDE */
        *:not(i):not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not(.fad):not(.bi):not([class*="fa-"]):not([class*="bi-"]):not(.slick-arrow) {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        }

        /* Preserve Font Awesome and other icon fonts */
        i, .fa, .fas, .far, .fab, .fal, .fad, .bi,
        [class*="fa-"], [class*="bi-"], .slick-arrow {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "bootstrap-icons" !important;
        }

        /* Font Awesome solid icons need font-weight 900 */
        .fas, i.fas {
            font-weight: 900 !important;
        }

        /* Font Awesome regular icons need font-weight 400 */
        .far, i.far {
            font-weight: 400 !important;
        }

        /* Font Awesome brands icons */
        .fab, i.fab {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400 !important;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body, p, span:not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]),
        div, a, li, label,
        h1, h2, h3, h4, h5, h6,
        button, .btn, input, textarea, select,
        .nav-link, .dropdown-item, .card,
        table, th, td {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        /* Headings with Poppins */
        h1, h2, h3, h4, h5, h6,
        .heading, .title {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif !important;
            font-weight: 700 !important;
            letter-spacing: -0.02em;
        }

        /* Arabic font override */
        html[lang="ar"] *:not(i):not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]):not([class*="bi-"]),
        html[dir="rtl"] *:not(i):not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]):not([class*="bi-"]),
        [dir="rtl"] *:not(i):not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]):not([class*="bi-"]) {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        html[lang="ar"] body,
        html[dir="rtl"] body,
        [dir="rtl"] body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        /* Arabic specific elements with Cairo - match English specificity */
        html[lang="ar"] body, html[lang="ar"] p, html[lang="ar"] span:not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]),
        html[lang="ar"] div, html[lang="ar"] a, html[lang="ar"] li, html[lang="ar"] label,
        html[lang="ar"] h1, html[lang="ar"] h2, html[lang="ar"] h3, html[lang="ar"] h4, html[lang="ar"] h5, html[lang="ar"] h6,
        html[lang="ar"] button, html[lang="ar"] .btn, html[lang="ar"] input, html[lang="ar"] textarea, html[lang="ar"] select,
        html[lang="ar"] .nav-link, html[lang="ar"] .dropdown-item, html[lang="ar"] .card,
        html[lang="ar"] table, html[lang="ar"] th, html[lang="ar"] td,
        html[dir="rtl"] body, html[dir="rtl"] p, html[dir="rtl"] span:not(.fa):not(.fas):not(.far):not(.fab):not(.fal):not([class*="fa-"]),
        html[dir="rtl"] div, html[dir="rtl"] a, html[dir="rtl"] li, html[dir="rtl"] label,
        html[dir="rtl"] h1, html[dir="rtl"] h2, html[dir="rtl"] h3, html[dir="rtl"] h4, html[dir="rtl"] h5, html[dir="rtl"] h6,
        html[dir="rtl"] button, html[dir="rtl"] .btn, html[dir="rtl"] input, html[dir="rtl"] textarea, html[dir="rtl"] select,
        html[dir="rtl"] .nav-link, html[dir="rtl"] .dropdown-item, html[dir="rtl"] .card,
        html[dir="rtl"] table, html[dir="rtl"] th, html[dir="rtl"] td {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        /* Arabic headings with Cairo */
        html[lang="ar"] h1, html[lang="ar"] h2, html[lang="ar"] h3,
        html[lang="ar"] h4, html[lang="ar"] h5, html[lang="ar"] h6,
        html[lang="ar"] .heading, html[lang="ar"] .title,
        html[dir="rtl"] h1, html[dir="rtl"] h2, html[dir="rtl"] h3,
        html[dir="rtl"] h4, html[dir="rtl"] h5, html[dir="rtl"] h6,
        html[dir="rtl"] .heading, html[dir="rtl"] .title {
            font-family: 'Cairo', sans-serif !important;
            font-weight: 700 !important;
        }

        /* Reduce overall padding and margins across the site */

        /* Compact sections */
        section, .section {
            padding: 30px 0 !important;
        }

        /* Compact headers */
        h1 { font-size: 28px !important; margin-bottom: 16px !important; }
        h2 { font-size: 24px !important; margin-bottom: 14px !important; }
        h3 { font-size: 20px !important; margin-bottom: 12px !important; }
        h4 { font-size: 18px !important; margin-bottom: 10px !important; }
        h5 { font-size: 16px !important; margin-bottom: 8px !important; }
        h6 { font-size: 14px !important; margin-bottom: 8px !important; }

        /* Compact product cards */
        .product-card {
            padding: 12px !important;
        }

        .product-card img {
            max-height: 200px !important;
            object-fit: cover;
        }

        .product-card .product-name {
            font-size: 14px !important;
            margin-bottom: 6px !important;
        }

        .product-card .product-price {
            font-size: 16px !important;
        }

        /* Compact buttons */
        .btn, button:not(.slick-arrow):not(.quantity-btn):not(.tab-btn-modern):not(.clear-search-btn) {
            padding: 8px 16px !important;
            font-size: 14px !important;
        }

        /* Compact hero section */
        .hero-section {
            min-height: 400px !important;
            padding: 40px 0 !important;
        }

        .hero-content h1 {
            font-size: 32px !important;
            margin-bottom: 12px !important;
        }

        .hero-content p {
            font-size: 16px !important;
            margin-bottom: 20px !important;
        }

        /* Compact header */
        .main-header {
            padding: 12px 0 !important;
        }

        /* Compact footer */
        footer {
            padding: 30px 0 15px 0 !important;
        }

        footer h5 {
            margin-bottom: 12px !important;
        }

        footer ul li {
            margin-bottom: 6px !important;
        }

        /* Compact breadcrumb */
        .breadcrumb-section, .modern-breadcrumb {
            padding: 12px 0 !important;
        }

        /* Product detail page compact */
        .product-detail-modern {
            padding: 40px 0 !important;
        }

        .product-title-modern {
            font-size: 26px !important;
            margin-bottom: 14px !important;
        }

        .current-price {
            font-size: 32px !important;
        }

        .price-section-modern {
            padding: 16px !important;
            margin-bottom: 16px !important;
        }

        .product-short-description {
            font-size: 14px !important;
            margin-bottom: 20px !important;
        }

        .variant-group {
            margin-bottom: 16px !important;
        }

        .quantity-section-modern {
            margin-bottom: 20px !important;
        }

        .action-buttons-modern {
            margin-bottom: 20px !important;
        }

        .product-features-modern {
            padding: 14px !important;
            margin-bottom: 20px !important;
        }

        .product-tabs-modern {
            margin-top: 40px !important;
        }

        .tab-content-modern {
            padding: 24px !important;
        }

        .review-summary-modern {
            padding: 20px !important;
            margin-bottom: 24px !important;
        }

        .review-score-number {
            font-size: 42px !important;
        }

        .review-form-modern {
            padding: 20px !important;
            margin-bottom: 24px !important;
        }

        .review-item-modern {
            padding: 16px !important;
        }

        /* Search results compact */
        .search-results-page .search-header {
            padding: 24px 0 !important;
        }

        .search-title {
            font-size: 24px !important;
        }

        .products-grid-modern {
            gap: 16px !important;
        }

        .product-card-modern {
            padding: 12px !important;
        }

        .product-card-modern .product-image-wrapper {
            height: 200px !important;
        }

        /* Compact category cards */
        .category-card {
            padding: 16px !important;
        }

        .category-card h3 {
            font-size: 16px !important;
            margin-top: 8px !important;
        }

        /* Compact spacing utilities */
        .mt-5, .my-5 { margin-top: 24px !important; }
        .mb-5, .my-5 { margin-bottom: 24px !important; }
        .pt-5, .py-5 { padding-top: 24px !important; }
        .pb-5, .py-5 { padding-bottom: 24px !important; }

        .mt-4, .my-4 { margin-top: 16px !important; }
        .mb-4, .my-4 { margin-bottom: 16px !important; }
        .pt-4, .py-4 { padding-top: 16px !important; }
        .pb-4, .py-4 { padding-bottom: 16px !important; }

        .mt-3, .my-3 { margin-top: 12px !important; }
        .mb-3, .my-3 { margin-bottom: 12px !important; }
        .pt-3, .py-3 { padding-top: 12px !important; }
        .pb-3, .py-3 { padding-bottom: 12px !important; }

        /* Compact container padding */
        .container {
            padding-right: 15px !important;
            padding-left: 15px !important;
        }

        /* ====================================
           MOBILE RESPONSIVE STYLES
           ==================================== */

        /* Tablet styles */
        @media (max-width: 991px) {
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Product grids - 2 columns on tablet */
            .products-grid, .product-grid, .products-grid-modern {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }

            .row.g-4 {
                --bs-gutter-x: 12px !important;
                --bs-gutter-y: 12px !important;
            }

            /* Category grids */
            .category-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            h1 { font-size: 22px !important; }
            h2 { font-size: 18px !important; }
            h3 { font-size: 16px !important; }
            h4 { font-size: 15px !important; }

            section, .section {
                padding: 16px 0 !important;
            }

            .hero-section, .hero-slider {
                min-height: 250px !important;
                padding: 20px 0 !important;
            }

            .hero-content h1 {
                font-size: 22px !important;
            }

            .hero-content p {
                font-size: 14px !important;
            }

            /* Product grids - 2 columns on mobile */
            .products-grid, .product-grid, .products-grid-modern {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            /* Product cards compact */
            .product-card, .product-card-modern {
                padding: 8px !important;
                border-radius: 10px !important;
            }

            .product-card img,
            .product-card-modern img,
            .product-image-wrapper {
                height: 140px !important;
                border-radius: 8px !important;
            }

            .product-card .product-name,
            .product-name-modern {
                font-size: 12px !important;
                line-height: 1.3 !important;
                margin-bottom: 4px !important;
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .product-card .product-price,
            .product-price-modern,
            .current-price-modern {
                font-size: 14px !important;
            }

            .old-price-modern {
                font-size: 11px !important;
            }

            /* Hide some elements on mobile */
            .product-card .product-description,
            .product-description-preview {
                display: none !important;
            }

            /* Compact badges */
            .product-badge, .discount-badge, .badge {
                font-size: 9px !important;
                padding: 2px 6px !important;
            }

            /* Action buttons smaller */
            .product-actions, .product-actions-modern {
                gap: 4px !important;
            }

            .product-actions .btn,
            .product-actions-modern .btn,
            .add-to-cart-btn {
                padding: 6px 10px !important;
                font-size: 11px !important;
            }

            .add-to-cart-btn i {
                font-size: 12px !important;
            }

            /* Category cards */
            .category-card {
                padding: 10px !important;
            }

            .category-card img {
                height: 60px !important;
                width: 60px !important;
            }

            .category-card h3,
            .category-name {
                font-size: 12px !important;
            }

            /* Category grid - 3 columns on mobile */
            .category-grid {
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 8px !important;
            }

            /* Section titles */
            .section-title, .section-heading {
                font-size: 18px !important;
                margin-bottom: 12px !important;
            }

            /* Banner/Slider */
            .banner-slide, .hero-slide {
                height: 200px !important;
            }

            .banner-slide img, .hero-slide img {
                object-fit: cover;
            }

            .banner-content, .slide-content {
                padding: 15px !important;
            }

            .banner-content h2, .slide-content h2 {
                font-size: 18px !important;
            }

            .banner-content p, .slide-content p {
                font-size: 12px !important;
            }

            /* Buttons */
            .btn, button:not(.slick-arrow):not(.quantity-btn):not(.mobile-menu-toggle) {
                padding: 8px 14px !important;
                font-size: 13px !important;
            }

            .btn-lg {
                padding: 10px 18px !important;
                font-size: 14px !important;
            }

            /* Product detail page */
            .product-detail-modern {
                padding: 16px 0 !important;
            }

            .product-title-modern {
                font-size: 20px !important;
            }

            .current-price {
                font-size: 26px !important;
            }

            .product-gallery {
                margin-bottom: 16px !important;
            }

            /* Tabs */
            .tab-content-modern {
                padding: 12px !important;
            }

            .nav-tabs .nav-link {
                padding: 8px 12px !important;
                font-size: 13px !important;
            }

            /* Forms */
            .form-control {
                padding: 10px 12px !important;
                font-size: 14px !important;
            }

            /* Cart page */
            .cart-item {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .cart-item-image {
                width: 100% !important;
                max-width: 120px !important;
                margin-bottom: 10px !important;
            }

            /* Checkout */
            .checkout-form {
                padding: 12px !important;
            }

            /* Footer compact on mobile */
            footer .row > div {
                margin-bottom: 20px !important;
            }

            footer h5 {
                font-size: 14px !important;
                margin-bottom: 10px !important;
            }

            footer ul li {
                margin-bottom: 5px !important;
            }

            footer ul li a {
                font-size: 13px !important;
            }

            /* Cards */
            .card {
                border-radius: 10px !important;
            }

            .card-body {
                padding: 12px !important;
            }

            /* Slick slider arrows smaller */
            .slick-prev, .slick-next {
                width: 30px !important;
                height: 30px !important;
            }

            .slick-prev:before, .slick-next:before {
                font-size: 16px !important;
            }

            /* Slick dots */
            .slick-dots li button:before {
                font-size: 8px !important;
            }
        }

        /* Small mobile styles */
        @media (max-width: 480px) {
            h1 { font-size: 20px !important; }
            h2 { font-size: 17px !important; }

            .container, .container-fluid {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            /* Product grids - still 2 columns but tighter */
            .products-grid, .product-grid, .products-grid-modern {
                gap: 8px !important;
            }

            .product-card, .product-card-modern {
                padding: 6px !important;
            }

            .product-card img,
            .product-card-modern img,
            .product-image-wrapper {
                height: 120px !important;
            }

            .product-card .product-name,
            .product-name-modern {
                font-size: 11px !important;
            }

            .product-card .product-price,
            .product-price-modern {
                font-size: 13px !important;
            }

            /* Hide add to cart text on very small screens */
            .add-to-cart-btn .btn-text {
                display: none !important;
            }

            /* Category grid - 2 columns on very small */
            .category-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .category-card img {
                height: 50px !important;
                width: 50px !important;
            }

            /* Banner height */
            .banner-slide, .hero-slide {
                height: 180px !important;
            }

            .banner-content h2, .slide-content h2 {
                font-size: 16px !important;
            }

            /* Section padding */
            section, .section {
                padding: 12px 0 !important;
            }

            /* Footer */
            footer {
                padding: 20px 0 10px 0 !important;
            }
        }

        /* RTL: Increase spacing between arrows and text */
        html[lang="ar"] .fa-arrow-right,
        html[lang="ar"] .fa-arrow-left,
        html[dir="rtl"] .fa-arrow-right,
        html[dir="rtl"] .fa-arrow-left {
            margin-inline-start: 12px !important;
            margin-inline-end: 12px !important;
        }

        html[lang="ar"] .ms-1,
        html[dir="rtl"] .ms-1 {
            margin-inline-start: 12px !important;
        }

        html[lang="ar"] .ms-2,
        html[dir="rtl"] .ms-2 {
            margin-inline-start: 16px !important;
        }

        html[lang="ar"] .me-1,
        html[dir="rtl"] .me-1 {
            margin-inline-end: 12px !important;
        }

        html[lang="ar"] .me-2,
        html[dir="rtl"] .me-2 {
            margin-inline-end: 16px !important;
        }
    </style>

</head>
<body>
    @if(in_array(app()->getLocale(), ['ar', 'fa', 'he']))
    <script>
        // Force Cairo font for Arabic/RTL languages
        (function() {
            function applyCairoFont() {
                const allElements = document.querySelectorAll('*:not(i):not(.fa):not(.fas):not(.far):not(.fab):not([class*="fa-"]):not([class*="bi-"])');

                allElements.forEach(function(el) {
                    el.style.setProperty('font-family', 'Cairo, sans-serif', 'important');
                });

                document.documentElement.style.setProperty('font-family', 'Cairo, sans-serif', 'important');
                document.body.style.setProperty('font-family', 'Cairo, sans-serif', 'important');
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyCairoFont);
            } else {
                applyCairoFont();
            }

            setTimeout(applyCairoFont, 500);
        })();
    </script>
    @endif
    @include('themes.xylo.layouts.header')
    <main>
        @yield('content')
    </main>
    @include('themes.xylo.layouts.footer')
    @if (!App::environment('testing'))
        @vite(['resources/views/themes/xylo/js/app.js'])
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (!App::environment('testing'))
        @vite(['resources/views/themes/xylo/js/slick.min.js'])
    @endif
    @if (!App::environment('testing'))
        @vite(['resources/views/themes/xylo/js/main.js'])
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('js')
    <script>
        $(document).ready(function () {
            $('.category-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                dots: false,
                arrows: true,
                prevArrow: '<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="fa fa-angle-right"></i></button>',
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
            $('.banner-slider, .hero-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                fade: true,
                speed: 500,
                cssEase: 'linear',
                autoplaySpeed: 5000,
                dots: true,
                arrows: false,
            });
            $('.product-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                prevArrow: $('.prev'),
                nextArrow: $('.next'),
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        /* header script */
        document.addEventListener('DOMContentLoaded', function() {
            const accountToggle = document.getElementById('accountDropdown');
            const accountMenu = document.querySelector('.account-menu');

            if (accountToggle && accountMenu) {
                document.addEventListener('click', function(event) {
                    if (!accountToggle.contains(event.target) && !accountMenu.contains(event.target)) {
                        accountMenu.classList.remove('show');
                    }
                });
            }
        });
    </script>
    <script>
        /* product seach input */
        $(document).ready(function () {
            $('#search-input').on('keyup', function () {
                let query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: '{{ url('/search-suggestions') }}',
                        type: 'GET',
                        data: { q: query },
                        success: function (data) {
                            let suggestions = $('#search-suggestions');
                            suggestions.html('');
                            if (data.length > 0) {
                                data.forEach(product => {
                                    suggestions.append(`
                                        <a href="/product/${product.slug}" class="dropdown-item d-flex align-items-center">
                                            <img src="${product.thumbnail}" alt="${product.name}" class="me-2" width="40" height="40" style="object-fit: cover; border-radius: 5px;">
                                            <span class="search-product-title">${product.name}</span>
                                        </a>
                                    `);
                                });
                                suggestions.removeClass('d-none');
                            } else {
                                suggestions.addClass('d-none');
                            }
                        }
                    });
                } else {
                    $('#search-suggestions').addClass('d-none');
                }
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('#search-input, #search-suggestions').length) {
                    $('#search-suggestions').addClass('d-none');
                }
            });
        });


    </script>
</body>
</html>