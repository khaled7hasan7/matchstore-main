<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'fa']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic Page Title from Site Settings --}}
    <title>@yield('title', ($siteSettings->site_name ?? config('app.name', 'Store')) . ' - Admin')</title>

    {{-- Favicon from Site Settings --}}
    @if($siteSettings && $siteSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet">
    <style>
        /* Global Font - Poppins for English, Cairo for Arabic */
        body,
        .nav-link, .btn, .card, .form-control, .form-label,
        .dropdown-item, .modal-body, .modal-title,
        h1, h2, h3, h4, h5, h6, p, span, div,
        table, th, td, a, li {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        /* Arabic font override */
        [dir="rtl"] body,
        [dir="rtl"] .nav-link,
        [dir="rtl"] .btn,
        [dir="rtl"] .card,
        [dir="rtl"] .form-control,
        [dir="rtl"] .form-label,
        [dir="rtl"] .dropdown-item,
        [dir="rtl"] .modal-body,
        [dir="rtl"] .modal-title,
        [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3,
        [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6,
        [dir="rtl"] p, [dir="rtl"] span, [dir="rtl"] div,
        [dir="rtl"] table, [dir="rtl"] th, [dir="rtl"] td,
        [dir="rtl"] a, [dir="rtl"] li {
            font-family: 'Cairo', sans-serif !important;
        }

        /* Remove sidebar submenu indentation in RTL */
        [dir="rtl"] #sidebar .nav.flex-column.ms-3,
        [dir="rtl"] #sidebar ul.ms-3,
        [dir="rtl"] #sidebar .ms-3 {
            margin-right: 0 !important;
            margin-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Adjust sidebar padding in RTL */
        [dir="rtl"] #sidebar {
            padding-right: 0.5rem !important;
            padding-left: 0.5rem !important;
        }

        /* Adjust nav-link padding in RTL */
        [dir="rtl"] #sidebar .nav-link {
            padding-right: 0.25rem !important;
            padding-left: 0.5rem !important;
        }

        /* Adjust icons in RTL sidebar */
        [dir="rtl"] #sidebar .nav-link i {
            margin-left: 0.5rem !important;
            margin-right: 0 !important;
        }

        /* Content Area Margin Adjustments for Sidebar */
        #content {
            margin-left: 70px;
            transition: margin-left 0.3s ease;
        }

        .modern-sidebar:hover + #content,
        .modern-sidebar.expanded + #content {
            margin-left: 250px;
        }

        /* RTL Content Adjustments - already in _rtl.scss but adding here for completeness */
        [dir="rtl"] #content {
            margin-right: 70px;
            margin-left: 0;
            transition: margin-right 0.3s ease;
        }

        [dir="rtl"] .modern-sidebar:hover + #content,
        [dir="rtl"] .modern-sidebar.expanded + #content {
            margin-right: 250px;
            margin-left: 0;
        }

        /* Fix DataTables select dropdown overlap - LTR */
        .dataTables_length select,
        select[name*="length"],
        .form-select {
            padding-right: 2.5rem !important;
            background-position: right 0.75rem center !important;
        }

        /* Fix DataTables select dropdown overlap - RTL */
        [dir="rtl"] .dataTables_length select,
        [dir="rtl"] select[name*="length"],
        [dir="rtl"] .form-select {
            padding-left: 2.5rem !important;
            padding-right: 0.75rem !important;
            background-position: left 0.75rem center !important;
        }

        /* DataTables Pagination - Final Fix */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.25rem !important;
            padding: 0 !important;
            float: none !important;
        }

        .dataTables_wrapper .dataTables_paginate *:not(.paginate_button):not(.ellipsis) {
            display: inline !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            background: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-block !important;
            padding: 8px 16px !important;
            margin: 0 4px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 6px !important;
            background-color: #fff !important;
            background-image: none !important;
            color: #495057 !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #f8f9fa !important;
            background-image: none !important;
            border-color: #adb5bd !important;
            color: #212529 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:active {
            background: #fff !important;
            background-color: #fff !important;
            background-image: none !important;
            border: 2px solid #0d6efd !important;
            border-color: #0d6efd !important;
            color: #0d6efd !important;
            font-weight: 600 !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current *,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover *,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus *,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:active * {
            color: #0d6efd !important;
        }

        /* Additional specificity for stubborn DataTables */
        .dataTables_wrapper .dataTables_paginate span.paginate_button.current,
        .dataTables_wrapper .dataTables_paginate a.paginate_button.current {
            background: #fff !important;
            background-color: #fff !important;
            border: 2px solid #0d6efd !important;
            color: #0d6efd !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background-color: #fff !important;
            background-image: none !important;
            border-color: #dee2e6 !important;
            color: #6c757d !important;
            cursor: not-allowed !important;
            opacity: 0.5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .ellipsis {
            display: inline-block !important;
            padding: 8px 4px !important;
            color: #6c757d !important;
        }

        /* RTL Support */
        [dir="rtl"] .dataTables_wrapper .dataTables_paginate {
            direction: ltr !important;
        }
    </style>
    @yield('css')
</head>
<body>
    @include('admin.layouts.sidebar')
    
    <!-- Content Area -->
    <div id="content" class="w-100">
        <nav class="navbar navbar-expand navbar-light bg-light p-3">
            <!-- Language Change Dropdown -->
            <div class="dropdown ms-auto me-3">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    @php
                        $currentLang = app()->getLocale();
                        $langFlag = $currentLang == 'ar' ? 'sa' : 'us';
                        $langName = $currentLang == 'ar' ? __('cms.languages.arabic') : __('cms.languages.english');
                    @endphp
                    <img src="https://flagcdn.com/w40/{{ $langFlag }}.png" width="20"> {{ $langName }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item language-select {{ app()->getLocale() == 'en' ? 'active' : '' }}" data-lang="en" href="#"><img src="https://flagcdn.com/w40/us.png" width="20"> {{ __('cms.languages.english') }}</a></li>
                    <li><a class="dropdown-item language-select {{ app()->getLocale() == 'ar' ? 'active' : '' }}" data-lang="ar" href="#"><img src="https://flagcdn.com/w40/sa.png" width="20"> {{ __('cms.languages.arabic') }}</a></li>
                </ul>
            </div>
             <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                   <img src="{{ auth()->user()->profile_image
                        ? (\Illuminate\Support\Str::startsWith(auth()->user()->profile_image, ['http://', 'https://'])
                            ? auth()->user()->profile_image
                            : asset('storage/' . auth()->user()->profile_image))
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0d6efd&color=fff&size=40' }}"
                        class="rounded-circle"
                        alt="Profile"
                        width="40"
                        height="40"
                        style="object-fit:cover;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" 
                        href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person-circle me-2"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item d-flex align-items-center" href="#"
                        onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (!App::environment('testing'))
        @vite(['resources/js/app.js'])
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const menuItems = document.querySelectorAll(".nav-item");
            searchInput.addEventListener("input", function () {
                const searchTerm = searchInput.value.toLowerCase();
                menuItems.forEach((item) => {
                    let linkTexts = item.querySelectorAll(".nav-link");
                    let matchFound = false;

                    linkTexts.forEach((link) => {
                        if (link.textContent.toLowerCase().includes(searchTerm)) {
                            matchFound = true;
                            link.closest(".nav-item").style.display = "block"; // Show matching items
                        } else {
                            link.closest(".nav-item").style.display = "none"; // Hide non-matching items
                        }
                    });

                    // If it's a parent menu and any child matches, show parent
                    let submenu = item.querySelector(".collapse");
                    if (submenu) {
                        let childLinks = submenu.querySelectorAll(".nav-link");
                        childLinks.forEach((childLink) => {
                            if (childLink.textContent.toLowerCase().includes(searchTerm)) {
                                matchFound = true;
                            }
                        });

                        if (matchFound) {
                            item.style.display = "block";
                            submenu.classList.add("show"); // Expand if match found
                        } else {
                            item.style.display = "none";
                            submenu.classList.remove("show"); // Collapse if no match
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Language selection
            $(document).on('click', '.language-select', function (e) {
                e.preventDefault();

                let lang = $(this).data('lang');

                $.ajax({
                    url: "{{ route('admin.change.language') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        lang: lang
                    },
                    success: function () {
                        location.reload(); // reload to apply translations
                    },
                    error: function () {
                        toastr.error("Failed to change language");
                    }
                });
            });

            // Sidebar auto-expand functionality
            const sidebar = $('#sidebar');

            if (sidebar.length) {
                // Initialize as collapsed
                sidebar.addClass('collapsed');

                // Expand on hover
                sidebar.on('mouseenter', function() {
                    $(this).removeClass('collapsed').addClass('expanded');
                });

                // Collapse when mouse leaves
                sidebar.on('mouseleave', function() {
                    $(this).removeClass('expanded').addClass('collapsed');
                });

                // Expand on click of any menu item
                sidebar.find('.menu-item, .submenu-item').on('click', function() {
                    sidebar.removeClass('collapsed').addClass('expanded');
                });
            }
        });
    </script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('js')
</body>
</html>