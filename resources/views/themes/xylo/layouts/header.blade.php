<header class="modern-header">
    {{-- Notification Bar --}}
    @include('themes.xylo.partials.notification-bar')

    {{-- Wishlist Count --}}
    @php
        $wishlistCount = 0;
        if (auth('customer')->check()) {
            $wishlistCount = auth('customer')->user()->wishlistProducts()->count();
        }

        // Get categories for search filter (cached per language)
        $searchCategories = Cache::remember('search_categories_' . app()->getLocale(), 3600, function() {
            return \App\Models\Category::where('status', 1)
                ->with('translation')
                ->get();
        });
    @endphp

    {{-- Top Bar with Offers Message --}}
    <div class="header-top-bar">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="top-bar-message">
                    <i class="fas fa-bolt me-2"></i>
                    {{ __('store.header.top_bar_message') }}
                </div>
                <div class="top-bar-actions d-none d-md-flex gap-3">
                    {{-- Language Selector --}}
                    <div class="dropdown">
                        <button class="top-select dropdown-toggle border-0 bg-transparent text-white d-flex align-items-center gap-2"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            @php
                                $currentLang = app()->getLocale();
                                $flags = ['en' => 'us', 'ar' => 'sa'];
                                $names = ['en' => 'English', 'ar' => 'العربية'];
                            @endphp
                            <span class="fi fi-{{ $flags[$currentLang] ?? 'us' }}" style="width: 20px; height: 15px;"></span>
                            <span>{{ $names[$currentLang] ?? 'English' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center gap-2" data-lang="en" onclick="changeLanguage('en'); return false;">
                                    <span class="fi fi-us"></span> English
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item d-flex align-items-center gap-2" data-lang="ar" onclick="changeLanguage('ar'); return false;">
                                    <span class="fi fi-sa"></span> العربية
                                </a>
                            </li>
                        </ul>
                        <form id="language-change-form" action="{{ route('change.store.language') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="lang" id="lang-input" value="">
                        </form>
                    </div>

                    {{-- Currency Selector --}}
                    <div class="dropdown">
                        <button class="top-select dropdown-toggle border-0 bg-transparent text-white d-flex align-items-center gap-2"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            @php
                                $currentCurrency = session('currency', 'USD');
                                $currencyFlags = [
                                    'USD' => 'us',
                                    'NIS' => 'ps',
                                    'JOD' => 'jo'
                                ];
                                $currentCurrencyData = \App\Models\Currency::where('code', $currentCurrency)->first();
                            @endphp
                            @if($currentCurrencyData)
                                <span class="fi fi-{{ $currencyFlags[$currentCurrency] ?? 'us' }}" style="width: 20px; height: 15px;"></span>
                                <span>{{ $currentCurrencyData->symbol }} {{ strtoupper($currentCurrencyData->code) }}</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach (\App\Models\Currency::all() as $currency)
                                <li>
                                    <a href="#" class="dropdown-item d-flex align-items-center gap-2"
                                       onclick="changeCurrency('{{ $currency->code }}'); return false;">
                                        <span class="fi fi-{{ $currencyFlags[$currency->code] ?? 'us' }}"></span>
                                        {{ $currency->symbol }} {{ strtoupper($currency->code) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <form id="currency-change-form" action="{{ route('change.currency') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="currency_code" id="currency-input" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Header Section --}}
    <div class="header-main">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-3">
                {{-- Logo Section --}}
                <div class="logo-section">
                    <a href="{{ route('xylo.home') }}" class="brand-logo">
                        @if($siteSettings && $siteSettings->logo)
                            <img src="{{ asset('storage/' . $siteSettings->logo) }}"
                                 alt="{{ $siteSettings->site_name ?? 'Logo' }}"
                                 class="logo-image">
                        @else
                            <div class="logo-placeholder">
                                <i class="fas fa-store"></i>
                            </div>
                        @endif
                        @if($siteSettings && $siteSettings->site_name)
                            <span class="brand-name">{{ $siteSettings->site_name }}</span>
                        @endif
                    </a>
                </div>

                {{-- Search Section - Completely Redesigned --}}
                <div class="search-section flex-grow-1 mx-4">
                    <form class="ultra-modern-search" action="{{ url('/search') }}" method="GET">
                        <div class="search-wrapper">
                            {{-- Animated Search Icon --}}
                            <div class="search-icon-animated">
                                <svg class="search-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                                    <path d="M16 16L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>

                            {{-- Search Input with Floating Label --}}
                            <div class="input-group-modern">
                                <input type="text"
                                       class="search-input-ultra"
                                       id="search-input-new"
                                       name="q"
                                       placeholder=" "
                                       autocomplete="off">
                                <label for="search-input-new" class="floating-label">
                                    {{ __('store.header.search_placeholder') }}
                                </label>

                                {{-- Clear Button --}}
                                <button type="button" class="clear-search-btn" style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            {{-- Category Pills --}}
                            <div class="category-selector-modern">
                                <div class="category-trigger">
                                    <span class="selected-category-text">{{ __('store.header.all_categories') }}</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <select name="category" class="category-select-hidden">
                                    <option value="">{{ __('store.header.all_categories') }}</option>
                                    @foreach($searchCategories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->translation->name ?? $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- Category Dropdown --}}
                                <div class="category-dropdown-modern">
                                    <div class="category-option" data-value="">
                                        <i class="fas fa-th-large"></i>
                                        <span>{{ __('store.header.all_categories') }}</span>
                                        <i class="fas fa-check check-icon"></i>
                                    </div>
                                    @foreach($searchCategories as $category)
                                        <div class="category-option" data-value="{{ $category->id }}">
                                            <i class="fas fa-tag"></i>
                                            <span>{{ $category->translation->name ?? $category->name }}</span>
                                            <i class="fas fa-check check-icon"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Search Button --}}
                            <button type="submit" class="search-btn-ultra">
                                <span class="btn-bg-effect"></span>
                                <span class="btn-content">
                                    <i class="fas fa-search"></i>
                                    <span class="btn-text-ultra">{{ __('store.header.search') }}</span>
                                </span>
                            </button>
                        </div>

                        {{-- Live Search Suggestions --}}
                        <div id="search-suggestions-new" class="search-suggestions-ultra"></div>
                    </form>
                </div>

                {{-- Mobile Menu Toggle --}}
                <button class="mobile-menu-toggle d-lg-none" type="button" aria-label="Toggle menu">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                {{-- Action Icons Section --}}
                <div class="header-actions d-flex align-items-center gap-3">
                    {{-- Wishlist --}}
                    <a href="{{ auth('customer')->check() ? route('customer.wishlist.index') : route('customer.login') }}"
                       class="action-icon"
                       title="{{ __('store.header.wishlist') }}">
                        <div class="icon-wrapper">
                            <i class="far fa-heart"></i>
                            @if($wishlistCount > 0)
                                <span class="icon-badge">{{ $wishlistCount }}</span>
                            @endif
                        </div>
                        <span class="icon-label d-none d-lg-block">{{ __('store.header.wishlist') }}</span>
                    </a>

                    {{-- Account --}}
                    <div class="dropdown">
                        <a href="#"
                           class="action-icon dropdown-toggle"
                           data-bs-toggle="dropdown"
                           title="{{ __('store.header.account') }}">
                            <div class="icon-wrapper">
                                @auth('customer')
                                    @php $customer = Auth::guard('customer')->user(); @endphp
                                    @if($customer->profile_image)
                                        <img src="{{ asset('storage/' . $customer->profile_image) }}"
                                             alt="Profile"
                                             class="profile-pic">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=84cc16&color=fff"
                                             alt="Avatar"
                                             class="profile-pic">
                                    @endif
                                @else
                                    <i class="far fa-user"></i>
                                @endauth
                            </div>
                            <span class="icon-label d-none d-lg-block">{{ __('store.header.account') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown">
                            @guest('customer')
                                <li><a class="dropdown-item" href="{{ route('customer.login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('store.header.sign_in') }}
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.register') }}">
                                    <i class="fas fa-user-plus me-2"></i>{{ __('store.header.sign_up') }}
                                </a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}">
                                    <i class="fas fa-user-circle me-2"></i>{{ __('store.header.my_profile') }}
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>{{ __('store.header.my_orders') }}
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('store.header.logout') }}
                                    </a>
                                    <form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>

                    {{-- Cart --}}
                    <a href="{{ route('cart.view') }}"
                       class="action-icon cart-icon"
                       title="{{ __('store.header.cart') }}">
                        <div class="icon-wrapper">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="icon-badge cart-badge">
                                {{ session('cart') ? collect(session('cart'))->sum('quantity') : 0 }}
                            </span>
                        </div>
                        <span class="icon-label d-none d-lg-block">{{ __('store.header.cart') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <div class="header-navigation">
        <div class="container-fluid">
            @include('themes.xylo.partials.mega-menu')
        </div>
    </div>
</header>

<style>
    /* Modern Header Styles */
    .modern-header {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #ffffff;
    }

    /* Top Bar */
    .header-top-bar {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
        color: #ffffff;
        padding: 0.7rem 0;
        font-size: 0.875rem;
    }

    .top-bar-message {
        font-weight: 500;
    }

    .top-select {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: #ffffff;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .top-select:hover {
        background: rgba(255,255,255,0.3);
    }

    .top-select:focus {
        outline: none;
        border-color: rgba(255,255,255,0.5);
    }

    .top-select option {
        background: #1e293b;
        color: #ffffff;
    }

    /* RTL: Increase spacing between currency text and dropdown arrow */
    html[lang="ar"] .top-select,
    html[dir="rtl"] .top-select {
        padding-left: 2rem !important;
        padding-right: 0.8rem !important;
    }

    .top-bar-actions .dropdown-toggle {
        font-size: 0.875rem;
        padding: 0.4rem 0.8rem;
    }

    /* Currency dropdown flag styling */
    .top-bar-actions .dropdown-menu .fi {
        width: 20px;
        height: 15px;
        display: inline-block;
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .top-bar-actions .dropdown-toggle .fi {
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    /* RTL: Increase spacing for language dropdown arrow */
    html[lang="ar"] .top-bar-actions .dropdown-toggle,
    html[dir="rtl"] .top-bar-actions .dropdown-toggle {
        padding-left: 2rem !important;
        padding-right: 0.8rem !important;
    }

    /* Dropdown Menu Animations - Language & Currency */
    .top-bar-actions .dropdown-menu {
        margin-top: 0.5rem;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        background: white;
        padding: 0.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
        transform: translateY(-10px);
        pointer-events: none;
    }

    .top-bar-actions .dropdown-menu.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    .top-bar-actions .dropdown-item {
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .top-bar-actions .dropdown-item:last-child {
        margin-bottom: 0;
    }

    .top-bar-actions .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(132, 204, 22, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .top-bar-actions .dropdown-item:hover::before {
        left: 100%;
    }

    .top-bar-actions .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(132, 204, 22, 0.1), rgba(132, 204, 22, 0.05));
        color: var(--main-color);
        transform: translateX(5px);
    }

    .top-bar-actions .dropdown-item:active {
        transform: scale(0.98) translateX(5px);
    }

    /* RTL: Reverse slide direction */
    [dir="rtl"] .top-bar-actions .dropdown-item:hover,
    html[lang="ar"] .top-bar-actions .dropdown-item:hover {
        transform: translateX(-5px);
    }

    [dir="rtl"] .top-bar-actions .dropdown-item:active,
    html[lang="ar"] .top-bar-actions .dropdown-item:active {
        transform: scale(0.98) translateX(-5px);
    }

    /* Main Header */
    .header-main {
        background: #ffffff;
    }

    /* Logo Section - Enhanced */
    .logo-section {
        min-width: 200px;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .brand-logo:hover {
        transform: scale(1.05);
    }

    .brand-logo::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    .brand-logo:hover::after {
        width: 100%;
    }

    .logo-image {
        height: 90px;
        width: auto;
        filter: drop-shadow(0 2px 8px rgba(0,0,0,0.1));
        transition: all 0.3s ease;
    }

    .brand-logo:hover .logo-image {
        filter: drop-shadow(0 4px 12px rgba(132, 204, 22, 0.3));
    }

    .logo-placeholder {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2.5rem;
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.3);
        position: relative;
        overflow: hidden;
    }

    .logo-placeholder::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        animation: logoShine 3s infinite;
    }

    @keyframes logoShine {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
    }

    .brand-name {
        font-size: 2.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: none;
        letter-spacing: -0.5px;
    }

    @media (min-width: 992px) {
        .brand-name {
            display: block;
        }
    }

    @include('themes.xylo.partials.search-styles')
    /* Header Actions - Enhanced */
    .header-actions {
        min-width: 250px;
        justify-content: flex-end;
        gap: 8px;
    }

    .action-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .action-icon::before {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 30px;
        height: 2px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        transition: transform 0.3s ease;
        border-radius: 2px;
    }

    .action-icon:hover::before {
        transform: translateX(-50%) scaleX(1);
    }

    .action-icon:hover {
        color: var(--main-color);
    }

    .icon-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 14px;
        font-size: 1.3rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .action-icon:hover .icon-wrapper {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 8px 20px rgba(132, 204, 22, 0.4);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .action-icon:active .icon-wrapper {
        transform: translateY(-1px) scale(0.95);
    }

    .icon-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        border-radius: 50px;
        min-width: 22px;
        text-align: center;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.5);
        animation: badgePop 0.5s ease;
        border: 2px solid #ffffff;
    }

    @keyframes badgePop {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .cart-badge {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        box-shadow: 0 3px 8px rgba(132, 204, 22, 0.5);
    }

    .icon-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #64748b;
    }

    .action-icon:hover .icon-label {
        color: var(--main-color);
    }

    /* Fix dropdown arrow alignment for Account */
    .action-icon.dropdown-toggle::after {
        display: none;
    }

    .profile-pic {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--main-color);
    }

    /* Modern Dropdown - Enhanced */
    .modern-dropdown {
        border: none;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        border-radius: 1.2rem;
        padding: 0.75rem;
        min-width: 220px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.98);
        margin-top: 5rem !important;
        transform-origin: top center;
        animation: dropdownSlideIn 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @keyframes dropdownSlideIn {
        0% {
            opacity: 0;
            transform: scaleY(0.8);
        }
        100% {
            opacity: 1;
            transform: scaleY(1);
        }
    }

    .modern-dropdown .dropdown-item {
        border-radius: 0.6rem;
        padding: 0.85rem 1.1rem;
        font-size: 0.92rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .modern-dropdown .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(132, 204, 22, 0.15), transparent);
        transition: left 0.5s ease;
    }

    .modern-dropdown .dropdown-item:hover::before {
        left: 100%;
    }

    .modern-dropdown .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(132, 204, 22, 0.12), rgba(34, 211, 238, 0.12));
        color: var(--main-color);
        transform: translateX(5px);
    }

    .modern-dropdown .dropdown-item:active {
        transform: scale(0.98) translateX(5px);
    }

    .modern-dropdown .dropdown-item i {
        transition: transform 0.3s ease;
    }

    .modern-dropdown .dropdown-item:hover i {
        transform: scale(1.15) rotate(5deg);
    }

    /* Responsive Dropdown Spacing */
    @media (max-width: 991px) {
        .modern-dropdown {
            margin-top: 3rem !important;
        }
    }

    @media (max-width: 768px) {
        .modern-dropdown {
            margin-top: 3rem !important;
        }
    }

    /* RTL Support for Dropdown */
    [dir="rtl"] .modern-dropdown,
    html[dir="rtl"] .modern-dropdown,
    html[lang="ar"] .modern-dropdown {
        direction: rtl;
        text-align: right;
    }

    [dir="rtl"] .modern-dropdown .dropdown-item,
    html[dir="rtl"] .modern-dropdown .dropdown-item,
    html[lang="ar"] .modern-dropdown .dropdown-item {
        text-align: right;
    }

    [dir="rtl"] .modern-dropdown .dropdown-item::before,
    html[dir="rtl"] .modern-dropdown .dropdown-item::before,
    html[lang="ar"] .modern-dropdown .dropdown-item::before {
        left: auto;
        right: 0;
    }

    [dir="rtl"] .modern-dropdown .dropdown-item:hover,
    html[dir="rtl"] .modern-dropdown .dropdown-item:hover,
    html[lang="ar"] .modern-dropdown .dropdown-item:hover {
        transform: translateX(-5px);
    }

    [dir="rtl"] .modern-dropdown .dropdown-item:active,
    html[dir="rtl"] .modern-dropdown .dropdown-item:active,
    html[lang="ar"] .modern-dropdown .dropdown-item:active {
        transform: scale(0.98) translateX(-5px);
    }

    [dir="rtl"] .modern-dropdown .dropdown-item i,
    html[dir="rtl"] .modern-dropdown .dropdown-item i,
    html[lang="ar"] .modern-dropdown .dropdown-item i {
        margin-right: 0;
        margin-left: 8px;
    }

    /* Ripple Effect for Buttons */
    .search-submit-btn {
        position: relative;
        overflow: hidden;
    }

    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }


    /* Header Navigation */
    .header-navigation {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .modern-header.scrolled .header-navigation {
        border-top-color: #e2e8f0;
    }

    /* Responsive */
    /* iPad Pro and medium tablets */
    @media (max-width: 1199px) {
        .logo-section {
            min-width: 120px;
        }

        .logo-image {
            height: 60px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }

        .search-section {
            margin: 0 0.5rem !important;
            flex: 1;
            max-width: 500px;
        }

        .search-input-ultra {
            font-size: 0.85rem !important;
            padding: 12px 10px !important;
            white-space: nowrap;
        }

        .input-group-modern {
            min-height: 48px;
            padding: 4px 16px;
        }

        .category-trigger {
            padding: 8px 12px;
            min-width: 100px;
        }

        .selected-category-text {
            font-size: 0.75rem;
            max-width: 80px;
        }

        .search-btn-ultra {
            padding: 10px 20px;
            font-size: 0.85rem;
        }

        .icon-label {
            display: none !important;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .header-actions {
            min-width: auto;
            gap: 6px;
        }
    }

    /* iPad Mini and small tablets (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        /* Hide language/currency selectors - accessible via hamburger menu */
        .top-bar-actions {
            display: none !important;
        }

        .header-main .d-flex {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 10px !important;
        }

        /* Show hamburger on iPad Mini */
        .mobile-menu-toggle {
            display: flex !important;
            order: 1 !important;
            flex-shrink: 0;
        }

        .logo-section {
            min-width: auto;
            flex-shrink: 0;
            order: 2 !important;
        }

        .logo-image {
            height: 40px;
        }

        .logo-placeholder {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .brand-name {
            display: none !important;
        }

        .search-section {
            order: 3 !important;
            flex: 1 1 auto !important;
            display: flex !important;
            justify-content: center !important;
            margin: 0 10px !important;
            max-width: none !important;
            flex-basis: auto !important;
        }

        .ultra-modern-search {
            max-width: 100%;
            width: 100%;
        }

        .search-input-ultra {
            font-size: 0.75rem !important;
            padding: 8px 6px !important;
        }

        .input-group-modern {
            min-height: 40px;
            padding: 3px 10px;
            margin: 0 6px;
        }

        .category-trigger {
            padding: 5px 8px;
            min-width: 80px;
        }

        .selected-category-text {
            font-size: 0.65rem;
            max-width: 60px;
        }

        .search-btn-ultra {
            padding: 7px 14px;
            font-size: 0.75rem;
        }

        .icon-label {
            display: none !important;
        }

        .icon-wrapper {
            width: 36px;
            height: 36px;
            font-size: 0.95rem;
        }

        .header-actions {
            order: 4 !important;
            min-width: auto;
            gap: 4px;
            flex-shrink: 0;
            justify-content: flex-end;
            margin-left: auto !important;
        }
    }

    /* Mobile only (below iPad Mini) */
    @media (max-width: 767px) {
        .search-section {
            order: 3;
            flex-basis: 100%;
            margin: 1rem 0 0 0 !important;
        }

        .header-actions {
            min-width: auto;
        }

        .icon-label {
            display: none !important;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .search-container {
            border-radius: 50px;
        }

        .search-icon-left {
            padding-left: 1rem;
        }

        .search-category-select {
            max-width: 100px;
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .search-submit-btn {
            padding: 0.75rem 1.25rem;
        }

        .search-submit-btn .btn-text {
            display: none;
        }
    }

    @media (max-width: 575px) {
        .top-bar-message {
            font-size: 0.75rem;
        }

        .brand-name {
            font-size: 1.25rem;
        }

        .search-icon-left {
            padding-left: 0.75rem;
            padding-right: 0.5rem;
        }

        .search-input-main {
            font-size: 0.9rem;
            padding: 0.875rem 0.25rem;
        }

        .search-category-select {
            display: none;
        }

        .search-submit-btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .search-container {
            border-radius: 40px;
        }
    }

    /* ====================================
       COMPACT HEADER OVERRIDES
       ==================================== */

    /* Compact Top Bar */
    .header-top-bar {
        padding: 0.4rem 0 !important;
        font-size: 0.75rem !important;
    }

    .top-bar-message {
        font-size: 0.75rem !important;
    }

    .top-bar-message i {
        font-size: 0.7rem !important;
    }

    .top-select {
        padding: 0.3rem 0.6rem !important;
        font-size: 0.75rem !important;
    }

    .top-bar-actions .dropdown-toggle {
        padding: 0.3rem 0.6rem !important;
        font-size: 0.75rem !important;
    }

    /* RTL: Maintain spacing on compact mode */
    html[lang="ar"] .top-select,
    html[dir="rtl"] .top-select {
        padding-left: 1.8rem !important;
    }

    html[lang="ar"] .top-bar-actions .dropdown-toggle,
    html[dir="rtl"] .top-bar-actions .dropdown-toggle {
        padding-left: 1.8rem !important;
    }

    /* Compact Main Header */
    .header-main {
        padding: 0 !important;
    }

    .header-main .py-3 {
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* Compact Logo */
    .logo-section {
        min-width: 150px !important;
    }

    .logo-image {
        height: 65px !important;
    }

    .logo-placeholder {
        width: 65px !important;
        height: 65px !important;
        font-size: 1.9rem !important;
    }

    .brand-name {
        font-size: 1.9rem !important;
    }

    /* Compact Navigation */
    .header-navigation {
        padding: 0.5rem 0 !important;
    }

    .header-navigation .nav-link {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.85rem !important;
    }

    /* Compact Header Actions */
    .header-actions {
        gap: 0.75rem !important;
    }

    .header-action-btn {
        width: 36px !important;
        height: 36px !important;
        font-size: 0.9rem !important;
    }

    .header-action-btn .action-badge {
        width: 16px !important;
        height: 16px !important;
        font-size: 0.6rem !important;
        top: -4px !important;
        right: -4px !important;
    }

    /* Compact Search Bar in Header */
    .ultra-modern-search {
        max-width: 600px !important;
    }

    .input-group-modern {
        min-height: 42px !important;
        padding: 3px 16px !important;
    }

    .search-input-ultra {
        padding: 10px 8px !important;
        font-size: 0.85rem !important;
    }

    .search-btn-ultra {
        height: 36px !important;
        padding: 0 16px !important;
        min-width: auto !important;
    }

    .search-btn-ultra .btn-content {
        gap: 6px !important;
    }

    .btn-text-ultra {
        font-size: 0.85rem !important;
    }

    .category-trigger {
        padding: 6px 12px !important;
        font-size: 0.8rem !important;
    }

    /* Mobile Compact Header */
    @media (max-width: 768px) {
        .header-top-bar {
            padding: 0.3rem 0 !important;
        }

        .top-bar-message {
            font-size: 0.7rem !important;
        }

        .logo-image {
            height: 55px !important;
        }

        .logo-placeholder {
            width: 55px !important;
            height: 55px !important;
            font-size: 1.5rem !important;
        }

        .brand-name {
            font-size: 1.4rem !important;
        }

        .header-main .py-3 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .header-action-btn {
            width: 32px !important;
            height: 32px !important;
            font-size: 0.85rem !important;
        }

        .input-group-modern {
            min-height: 38px !important;
        }
    }

    /* ====================================
       MOBILE MENU STYLES
       ==================================== */

    /* Mobile Menu Toggle Button */
    .mobile-menu-toggle {
        display: none;
        background: transparent;
        border: none;
        padding: 8px;
        cursor: pointer;
        z-index: 1001;
    }

    .hamburger-icon {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 24px;
        height: 18px;
    }

    .hamburger-icon span {
        display: block;
        width: 100%;
        height: 2px;
        background-color: #1e293b;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* Hide hamburger when menu is open */
    .mobile-menu-toggle.active {
        visibility: hidden;
        transition: none !important;
    }

    .mobile-menu-toggle.active .hamburger-icon span {
        transition: none !important;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .mobile-menu-toggle {
            display: block;
            order: 1;
            margin-right: 0.75rem;
        }

        .header-main .d-flex {
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .logo-section {
            min-width: auto !important;
            order: 2;
            flex: 0 0 auto;
        }

        .search-section {
            order: 4;
            width: 100%;
            margin: 0.75rem 0 0 0 !important;
            flex-basis: 100%;
        }

        .header-actions {
            order: 3;
            min-width: auto !important;
            gap: 0.5rem !important;
            margin-left: auto;
        }

        /* RTL Mobile Layout - Keep same order, just adjust spacing */
        html[lang="ar"] .mobile-menu-toggle,
        html[dir="rtl"] .mobile-menu-toggle {
            margin-right: 0;
            margin-left: 0.75rem;
        }

        html[lang="ar"] .header-actions,
        html[dir="rtl"] .header-actions {
            margin-left: 0;
            margin-right: auto;
        }

        /* Hide navigation by default on mobile */
        .header-navigation {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            max-height: 70vh;
            background: #ffffff;
            z-index: 1000;
            overflow-y: auto;
            padding-top: 0;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-100%);
            transition: transform 0.3s ease-out;
        }

        .header-navigation.mobile-menu-open {
            display: block;
            animation: slideDown 0.3s ease-out forwards;
        }

        .header-navigation.mobile-menu-closing {
            display: block;
            animation: slideUp 0.3s ease-out forwards;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-100%);
            }
        }

        /* Ensure mega-menu displays properly on mobile */
        .header-navigation .mega-menu {
            display: block;
            width: 100%;
            margin-top: 70px;
            padding-top: 0;
        }

        /* Force mobile selectors to show on mobile screens */
        .mobile-selectors.d-lg-none {
            display: grid !important;
        }

        /* Mobile Selectors Styles - Dropdown Design */
        .mobile-selectors {
            display: grid !important;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border-bottom: 1px solid #e8e8e8;
            margin: 0;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .mobile-selector-item {
            position: relative;
        }

        .selector-dropdown {
            position: relative;
            width: 100%;
        }

        .selector-current {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e293b;
        }

        .selector-current:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .selector-dropdown.open .selector-current {
            border-color: var(--main-color);
            background: rgba(132, 204, 22, 0.05);
        }

        .selector-current .fi {
            width: 18px;
            height: 13px;
            display: inline-block;
            border-radius: 2px;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .selector-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .selector-arrow {
            font-size: 0.7rem;
            color: #64748b;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .selector-dropdown.open .selector-arrow {
            transform: rotate(180deg);
        }

        .selector-options-dropdown {
            position: absolute;
            top: calc(100% + 0.25rem);
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1050;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
        }

        .selector-dropdown.open .selector-options-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .selector-option-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 0.75rem;
            background: transparent;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            width: 100%;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
            text-align: left;
        }

        .selector-option-item:last-child {
            border-bottom: none;
        }

        .selector-option-item:hover {
            background: rgba(132, 204, 22, 0.1);
            color: var(--main-color);
        }

        .selector-option-item .fi {
            width: 18px;
            height: 13px;
            display: inline-block;
            border-radius: 2px;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* Icon wrapper sizing for mobile */
        .icon-wrapper {
            width: 38px !important;
            height: 38px !important;
            font-size: 1rem !important;
            border-radius: 10px !important;
        }

        .icon-badge {
            top: -4px !important;
            right: -4px !important;
            font-size: 0.65rem !important;
            padding: 0.15rem 0.35rem !important;
            min-width: 18px !important;
        }

        /* RTL: Icon badge on left side */
        html[lang="ar"] .icon-badge,
        html[dir="rtl"] .icon-badge {
            right: auto !important;
            left: -4px !important;
        }

        /* Hide wishlist label on mobile */
        .header-actions .icon-label {
            display: none !important;
        }

        /* Prevent body scroll when menu is open */
        body.mobile-menu-active {
            overflow: hidden;
        }

        /* Mobile menu close button */
        .mobile-menu-close {
            color: #ffffff !important;
        }

        .mobile-menu-close i {
            color: #ffffff !important;
        }

        /* RTL: Close button stays on right side (same as LTR) */

        /* Mobile menu close header */
        .header-navigation::before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
            z-index: 1;
        }

        .header-navigation::after {
            content: 'Menu';
            display: block;
            position: fixed;
            top: 18px;
            left: 20px;
            color: #ffffff;
            font-weight: 600;
            font-size: 1.1rem;
            z-index: 2;
        }

        /* RTL: Change menu text to Arabic */
        html[lang="ar"] .header-navigation::after,
        html[dir="rtl"] .header-navigation::after {
            content: 'القائمة';
        }
    }

    @media (max-width: 575px) {
        .logo-image {
            height: 45px !important;
        }

        .logo-placeholder {
            width: 45px !important;
            height: 45px !important;
            font-size: 1.3rem !important;
        }

        .icon-wrapper {
            width: 34px !important;
            height: 34px !important;
            font-size: 0.9rem !important;
        }

        .header-actions {
            gap: 0.35rem !important;
        }

        /* Compact search on small mobile */
        .search-section {
            margin-top: 0.5rem !important;
        }

        .ultra-modern-search .search-wrapper {
            padding: 4px !important;
        }

        .search-input-ultra {
            font-size: 0.8rem !important;
            padding: 8px !important;
        }

        .search-btn-ultra {
            height: 32px !important;
            padding: 0 12px !important;
        }

        .btn-text-ultra {
            display: none !important;
        }

        .category-selector-modern {
            display: none !important;
        }
    }
</style>

<script>
// Language change function
function changeLanguage(lang) {
    const form = document.getElementById('language-change-form');
    const langInput = document.getElementById('lang-input');

    if (form && langInput) {
        langInput.value = lang;
        form.submit();
    }
}

// Currency change function
function changeCurrency(currencyCode) {
    const form = document.getElementById('currency-change-form');
    const currencyInput = document.getElementById('currency-input');

    if (form && currencyInput) {
        currencyInput.value = currencyCode;
        form.submit();
    }
}

// Global function to update cart count badge
window.updateCartCount = function(cart, cartCount) {
    let totalCount = 0;

    // Use cart_count from server if provided
    if (typeof cartCount === 'number') {
        totalCount = cartCount;
    }
    // Calculate total count from cart object
    else if (typeof cart === 'object' && cart !== null) {
        totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    } else if (typeof cart === 'number') {
        totalCount = cart;
    }

    // Update the cart badge in header
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        cartBadge.textContent = totalCount;
    }

    // Also update any other cart count elements that might exist
    const cartCountElements = document.querySelectorAll('.badge-count, #cart-count');
    cartCountElements.forEach(element => {
        element.textContent = totalCount;
    });
};

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const headerNavigation = document.querySelector('.header-navigation');

    if (mobileToggle && headerNavigation) {
        // Create close button for mobile menu
        const closeBtn = document.createElement('button');
        closeBtn.className = 'mobile-menu-close';
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        closeBtn.style.cssText = `
            position: fixed;
            top: 12px;
            right: 15px;
            background: transparent;
            border: none;
            color: #ffffff !important;
            font-size: 1.5rem;
            z-index: 1002;
            padding: 8px;
            cursor: pointer;
            display: none;
        `;
        headerNavigation.appendChild(closeBtn);

        function openMenu() {
            mobileToggle.classList.add('active');
            headerNavigation.classList.add('mobile-menu-open');
            document.body.classList.add('mobile-menu-active');
            closeBtn.style.display = 'block';
        }

        function closeMenu() {
            mobileToggle.classList.remove('active');
            headerNavigation.classList.remove('mobile-menu-open');
            headerNavigation.classList.add('mobile-menu-closing');
            closeBtn.style.display = 'none';

            setTimeout(() => {
                headerNavigation.classList.remove('mobile-menu-closing');
                document.body.classList.remove('mobile-menu-active');
            }, 300);
        }

        mobileToggle.addEventListener('click', function() {
            if (headerNavigation.classList.contains('mobile-menu-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        closeBtn.addEventListener('click', closeMenu);

        // Close menu when clicking on "View All" buttons
        const viewAllBtns = headerNavigation.querySelectorAll('.btn-view-all-products');
        viewAllBtns.forEach(btn => {
            btn.addEventListener('click', closeMenu);
        });
    }
});
</script>

@include('themes.xylo.partials.search-scripts')
