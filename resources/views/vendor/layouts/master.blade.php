<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
    @yield('css')

    <style>
        /* Global Font - Poppins for English, Cairo for Arabic */
        body, h1, h2, h3, h4, h5, h6, p, span, div,
        .btn, .form-control, .form-label, input, textarea, select, a,
        .nav-link, .dropdown-item, .card, table, th, td, li {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        /* Arabic font override */
        [dir="rtl"] body, [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3,
        [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6, [dir="rtl"] p,
        [dir="rtl"] span, [dir="rtl"] div, [dir="rtl"] .btn,
        [dir="rtl"] .form-control, [dir="rtl"] .form-label,
        [dir="rtl"] input, [dir="rtl"] textarea, [dir="rtl"] select,
        [dir="rtl"] a, [dir="rtl"] .nav-link, [dir="rtl"] .dropdown-item,
        [dir="rtl"] .card, [dir="rtl"] table, [dir="rtl"] th,
        [dir="rtl"] td, [dir="rtl"] li {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
</head>
<body>
    @include('vendor.layouts.sidebar')

    <!-- Content Area -->
    <div id="content" class="w-100">
        <nav class="navbar navbar-expand navbar-light bg-light p-3">
            <button class="btn btn-dark" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <!-- Language Change Dropdown -->
            <div class="dropdown ms-auto me-3">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    @php
                        $currentLang = app()->getLocale();
                        $langFlag = $currentLang == 'ar' ? 'sa' : 'us';
                        $langName = $currentLang == 'ar' ? 'العربية' : 'English';
                    @endphp
                    <img src="https://flagcdn.com/w40/{{ $langFlag }}.png" width="20"> {{ $langName }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item language-select {{ app()->getLocale() == 'en' ? 'active' : '' }}" data-lang="en" href="#"><img src="https://flagcdn.com/w40/us.png" width="20"> English</a></li>
                    <li><a class="dropdown-item language-select {{ app()->getLocale() == 'ar' ? 'active' : '' }}" data-lang="ar" href="#"><img src="https://flagcdn.com/w40/sa.png" width="20"> العربية</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    @php
                        $vendor = Auth::guard('vendor')->user();
                    @endphp
                   <img src="{{ $vendor && $vendor->profile_image
                        ? (\Illuminate\Support\Str::startsWith($vendor->profile_image, ['http://', 'https://'])
                            ? $vendor->profile_image
                            : asset('storage/' . $vendor->profile_image))
                        : 'https://ui-avatars.com/api/?name=' . urlencode($vendor ? $vendor->name : 'V') . '&background=1976d2&color=fff&size=40' }}"
                        class="rounded-circle"
                        alt="Profile"
                        style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #e0e0e0;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('vendor.profile.edit') }}">Profile</a></li>
                    <li>
                        <form id="vendor-logout-form" action="{{ route('vendor.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('vendor-logout-form').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Modal for Confirmation -->
    <div class="modal fade" id="languageChangeModal" tabindex="-1" aria-labelledby="languageChangeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="languageChangeModalLabel">Change Language</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to change the language?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmChange" class="btn btn-primary">Yes, Change</button>
                </div>
            </div>
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
        $(document).on('click', '.language-select', function (e) {
            e.preventDefault();

            let lang = $(this).data('lang');

            $.ajax({
                url: "{{ route('vendor.change.language') }}",
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
    </script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('js')
</body>
</html>
