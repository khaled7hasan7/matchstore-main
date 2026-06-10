{{-- Mega Menu --}}
@php
    use App\Models\Category;
    use App\Models\Product;

    $currentLocale = app()->getLocale();

    // Get all categories (flat list, no hierarchy yet) - cache per language
    $categories = Cache::remember('category_tree_menu_' . $currentLocale, 3600, function() {
        return Category::where('status', 1)
            ->with('translation')
            ->orderBy('id', 'asc')
            ->get();
    });

    // Get featured products for the Products dropdown (using latest products with discount) - cache per language
    $featuredProducts = Cache::remember('mega_menu_featured_products_' . $currentLocale, 3600, function() {
        return Product::where('status', 1)
            ->with(['translation', 'images', 'primaryVariant'])
            ->whereHas('primaryVariant', function($q) {
                $q->whereNotNull('discount_price');
            })
            ->latest()
            ->take(3)
            ->get();
    });

    // Get new arrival products (exclude featured products to show different items) - cache per language
    $newProducts = Cache::remember('mega_menu_new_products_' . $currentLocale, 3600, function() use ($featuredProducts) {
        $featuredIds = $featuredProducts->pluck('id')->toArray();

        return Product::where('status', 1)
            ->with(['translation', 'images', 'primaryVariant'])
            ->whereNotIn('id', $featuredIds)
            ->latest()
            ->take(3)
            ->get();
    });
@endphp

<nav class="mega-menu">
    {{-- Mobile Only: Language and Currency Selectors --}}
    <div class="mobile-selectors d-lg-none">
        {{-- Language Selector --}}
        <div class="mobile-selector-item">
            <div class="selector-dropdown" onclick="this.classList.toggle('open')">
                @php
                    $currentLang = app()->getLocale();
                    $langData = [
                        'en' => ['flag' => 'us', 'name' => 'English'],
                        'ar' => ['flag' => 'sa', 'name' => 'العربية']
                    ];
                @endphp
                <div class="selector-current">
                    <span class="fi fi-{{ $langData[$currentLang]['flag'] }}"></span>
                    <span class="selector-text">{{ $langData[$currentLang]['name'] }}</span>
                    <i class="fas fa-chevron-down selector-arrow"></i>
                </div>
                <div class="selector-options-dropdown">
                    @foreach($langData as $code => $data)
                        @if($code !== $currentLang)
                            <button class="selector-option-item" onclick="event.stopPropagation(); changeLanguage('{{ $code }}'); return false;">
                                <span class="fi fi-{{ $data['flag'] }}"></span>
                                <span>{{ $data['name'] }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Currency Selector --}}
        <div class="mobile-selector-item">
            <div class="selector-dropdown" onclick="this.classList.toggle('open')">
                @php
                    $currentCurrency = session('currency', 'USD');
                    $currencyFlags = [
                        'USD' => 'us',
                        'NIS' => 'ps',
                        'JOD' => 'jo'
                    ];
                    $currentCurrencyData = \App\Models\Currency::where('code', $currentCurrency)->first();
                @endphp
                <div class="selector-current">
                    @if($currentCurrencyData)
                        <span class="fi fi-{{ $currencyFlags[$currentCurrency] ?? 'us' }}"></span>
                        <span class="selector-text">{{ $currentCurrencyData->symbol }} {{ strtoupper($currentCurrencyData->code) }}</span>
                        <i class="fas fa-chevron-down selector-arrow"></i>
                    @endif
                </div>
                <div class="selector-options-dropdown">
                    @foreach (\App\Models\Currency::all() as $currency)
                        @if($currency->code !== $currentCurrency)
                            <button class="selector-option-item" onclick="event.stopPropagation(); changeCurrency('{{ $currency->code }}'); return false;">
                                <span class="fi fi-{{ $currencyFlags[$currency->code] ?? 'us' }}"></span>
                                <span>{{ $currency->symbol }} {{ strtoupper($currency->code) }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <ul class="menu-list">
        {{-- Products Menu Item with Dropdown --}}
        <li class="menu-item has-dropdown">
            <a href="{{ route('shop.index') }}" class="menu-link">
                {{ __('store.header.products') }} <i class="fas fa-chevron-down ms-1"></i>
            </a>
            <div class="mega-dropdown products-dropdown">
                <div class="container-fluid">
                    <div class="row">
                        {{-- Featured Products Column --}}
                        <div class="col-md-6">
                            <h6 class="dropdown-section-title">
                                <i class="fas fa-star me-2"></i>{{ __('store.home.featured_products') }}
                            </h6>
                            <div class="products-grid">
                                @foreach($featuredProducts as $product)
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-card-mini">
                                        @if($product->images->first())
                                            @php
                                                $imageUrl = $product->images->first()->image_url;
                                                // Check if URL is external (starts with http/https)
                                                $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                                $finalUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                                            @endphp
                                            <img src="{{ $finalUrl }}"
                                                 alt="{{ $product->translation->name ?? 'Product' }}"
                                                 class="product-thumb"
                                                 loading="lazy"
                                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60?text=No+Image';">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div class="product-info-mini">
                                            <div class="product-name-mini">{{ $product->translation->name ?? 'Product' }}</div>
                                            <div class="product-price-mini">
                                                @if($product->primaryVariant)
                                                    @if($product->primaryVariant->discount_price)
                                                        <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->discount_price), 2) }}</span>
                                                        <span class="price-old">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                    @else
                                                        <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- New Arrivals Column --}}
                        <div class="col-md-6">
                            <h6 class="dropdown-section-title">
                                <i class="fas fa-sparkles me-2"></i>{{ __('store.header.new_arrivals') }}
                            </h6>
                            <div class="products-grid">
                                @foreach($newProducts as $product)
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-card-mini">
                                        @if($product->images->first())
                                            @php
                                                $imageUrl = $product->images->first()->image_url;
                                                // Check if URL is external (starts with http/https)
                                                $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                                $finalUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                                            @endphp
                                            <img src="{{ $finalUrl }}"
                                                 alt="{{ $product->translation->name ?? 'Product' }}"
                                                 class="product-thumb"
                                                 loading="lazy"
                                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60?text=No+Image';">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div class="product-info-mini">
                                            <div class="product-name-mini">{{ $product->translation->name ?? 'Product' }}</div>
                                            <div class="product-price-mini">
                                                @if($product->primaryVariant)
                                                    @if($product->primaryVariant->discount_price)
                                                        <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->discount_price), 2) }}</span>
                                                        <span class="price-old">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                    @else
                                                        <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- View All Products Button --}}
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="{{ route('shop.index') }}" class="btn-view-all-products">
                                {{ __('store.header.all_products') }} <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        {{-- Category Menu Items with Dropdowns --}}
        @foreach($categories as $category)
            @php
                // Get products for this category (up to 4 for the dropdown)
                $categoryProducts = Cache::remember('category_dropdown_products_' . $category->id . '_' . $currentLocale, 3600, function() use ($category) {
                    return Product::where('status', 1)
                        ->where('category_id', $category->id)
                        ->with(['translation', 'images', 'primaryVariant'])
                        ->latest()
                        ->take(4)
                        ->get();
                });
            @endphp

            <li class="menu-item has-dropdown">
                <a href="{{ route('category.show', $category->slug) }}" class="menu-link">
                    {{ $category->translation->name ?? $category->name }} <i class="fas fa-chevron-down ms-1"></i>
                </a>

                {{-- Category Dropdown --}}
                <div class="mega-dropdown category-dropdown">
                    <div class="container-fluid">
                        @if($categoryProducts->count() > 0)
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="dropdown-section-title">
                                        <i class="fas fa-tag me-2"></i>{{ $category->translation->name ?? $category->name }}
                                    </h6>
                                    <div class="products-grid">
                                        @foreach($categoryProducts as $product)
                                            <a href="{{ route('product.show', $product->slug) }}" class="product-card-mini">
                                                @if($product->images->first())
                                                    @php
                                                        $imageUrl = $product->images->first()->image_url;
                                                        $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
                                                        $finalUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);
                                                    @endphp
                                                    <img src="{{ $finalUrl }}"
                                                         alt="{{ $product->translation->name ?? 'Product' }}"
                                                         class="product-thumb"
                                                         loading="lazy"
                                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60?text=No+Image';">
                                                @else
                                                    <div class="product-thumb-placeholder">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                                <div class="product-info-mini">
                                                    <div class="product-name-mini">{{ $product->translation->name ?? 'Product' }}</div>
                                                    <div class="product-price-mini">
                                                        @if($product->primaryVariant)
                                                            @if($product->primaryVariant->discount_price)
                                                                <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->discount_price), 2) }}</span>
                                                                <span class="price-old">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                            @else
                                                                <span class="price-new">{{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- View All in Category Button --}}
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <a href="{{ route('category.show', $category->slug) }}" class="btn-view-all-products">
                                        {{ __('store.header.view_all') }} {{ $category->translation->name ?? $category->name }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12 text-center py-3">
                                    <p class="text-muted mb-2">{{ __('store.header.no_products_in_category') }}</p>
                                    <a href="{{ route('category.show', $category->slug) }}" class="btn-view-all-products">
                                        {{ __('store.header.browse_category') }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</nav>

<style>
    .mega-menu {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }

    .mega-menu .menu-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 0;
        flex-wrap: wrap;
    }

    .mega-menu .menu-item {
        position: relative;
    }

    .mega-menu .menu-link {
        display: block;
        padding: 1rem 1.25rem;
        color: #1e293b;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        white-space: nowrap;
        position: relative;
    }

    .mega-menu .menu-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--main-color), var(--main-color-light));
        transition: width 0.3s ease;
        border-radius: 3px 3px 0 0;
    }

    .mega-menu .menu-link:hover {
        color: var(--main-color);
    }

    .mega-menu .menu-link:hover::after {
        width: 80%;
    }

    .mega-menu .menu-link i {
        font-size: 0.75rem;
        transition: transform 0.3s ease;
    }

    .mega-menu .menu-item:hover .menu-link i {
        transform: rotate(180deg);
    }

    .mega-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 600px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 3px solid var(--main-color);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
        padding: 1rem;
        border-radius: 0 0 1rem 1rem;
    }

    .mega-menu .menu-item:hover .mega-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Products Dropdown Specific Styles */
    .products-dropdown {
        min-width: 650px;
        max-width: 750px;
    }

    /* Category Dropdown Specific Styles */
    .category-dropdown {
        min-width: 400px;
        max-width: 500px;
    }

    .dropdown-section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--main-color);
        display: flex;
        align-items: center;
    }

    .dropdown-section-title i {
        color: var(--main-color);
        font-size: 0.85rem;
    }

    .mega-menu .products-grid {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-card-mini {
        display: flex;
        gap: 0.6rem;
        padding: 0.5rem;
        text-decoration: none;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        background: #ffffff;
        border: 1px solid transparent;
    }

    .product-card-mini:hover {
        background: linear-gradient(135deg, color-mix(in srgb, var(--main-color) 5%, transparent), color-mix(in srgb, var(--main-color-light) 5%, transparent));
        border-color: var(--main-color);
        transform: translateX(5px);
        box-shadow: 0 4px 12px color-mix(in srgb, var(--main-color) 15%, transparent);
    }

    .product-info-mini {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.25rem;
        flex: 1;
    }

    .product-name-mini {
        color: #1e293b;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price-mini {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-price-mini .price-new {
        color: var(--main-color);
        font-weight: 700;
        font-size: 0.95rem;
    }

    .product-price-mini .price-old {
        color: #94a3b8;
        font-size: 0.8rem;
        text-decoration: line-through;
    }

    .btn-view-all-products {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px color-mix(in srgb, var(--main-color) 30%, transparent);
    }

    .btn-view-all-products:hover {
        background: linear-gradient(135deg, var(--grid-color-1), var(--main-color));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px color-mix(in srgb, var(--main-color) 40%, transparent);
        color: #ffffff;
    }

    .btn-view-all-products i {
        transition: transform 0.3s ease;
    }

    .btn-view-all-products:hover i {
        transform: translateX(5px);
    }

    .subcategory-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .subcategory-list li {
        margin-bottom: 0.75rem;
    }

    .subcategory-link {
        color: var(--dark-color);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s ease;
        display: inline-block;
    }

    .subcategory-link:hover {
        color: var(--accent-color);
        padding-left: 0.25rem;
    }

    .product-count {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-left: 0.25rem;
    }

    .featured-title {
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--accent-color);
        color: var(--dark-color);
    }

    .featured-products {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .featured-product-item {
        display: flex;
        gap: 0.75rem;
        text-decoration: none;
        padding: 0.5rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s ease;
    }

    .featured-product-item:hover {
        background-color: var(--secondary-color);
    }

    .product-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.25rem;
        border: 1px solid var(--border-color);
    }

    .product-thumb-placeholder {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--secondary-color);
        border: 1px solid var(--border-color);
        border-radius: 0.25rem;
        color: var(--text-muted);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.25rem;
        flex: 1;
    }

    .product-name {
        color: var(--dark-color);
        font-size: 0.85rem;
        line-height: 1.3;
    }

    .product-price {
        color: var(--accent-color);
        font-weight: 600;
        font-size: 0.9rem;
    }

    @media (max-width: 1024px) {
        .mega-dropdown {
            min-width: 400px;
        }

        .products-dropdown {
            min-width: 600px;
        }

        .mega-menu .products-grid {
            grid-template-columns: 1fr;
        }

        .mega-dropdown .col-md-4 {
            display: none;
        }
    }

    @media (max-width: 991px) {
        .mega-menu {
            padding: 1rem;
        }

        .mega-menu .menu-list {
            flex-direction: column;
            gap: 0;
        }

        .mega-menu .menu-item {
            border-bottom: 1px solid #e2e8f0;
        }

        .mega-menu .menu-link {
            padding: 1rem 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .mega-menu .menu-link i {
            transition: transform 0.3s ease;
        }

        .mega-menu .menu-link::after {
            display: none;
        }

        /* Expanded state - when menu is open */
        .mega-menu .menu-item.mobile-open .menu-link {
            color: var(--main-color);
        }

        .mega-dropdown {
            position: static;
            min-width: 100% !important;
            max-width: 100% !important;
            box-shadow: none;
            border: none;
            border-radius: 0;
            border-top: none;
            padding: 0;
            background: #f8fafc;
            transform: none;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease, padding 0.4s ease;
        }

        .products-dropdown,
        .category-dropdown {
            min-width: 100% !important;
            max-width: 100% !important;
        }

        /* Expanded state - rotate arrow down */
        .mega-menu .menu-item.mobile-open .menu-link i {
            transform: rotate(180deg);
        }

        /* Collapsed state - arrow points right */
        .mega-menu .menu-item:not(.mobile-open) .menu-link i {
            transform: rotate(-90deg);
        }

        .mega-menu .menu-item:not(.mobile-open) .menu-link {
            color: #1e293b;
        }

        .mega-menu .products-grid {
            grid-template-columns: 1fr;
        }

        .btn-view-all-products {
            width: 100%;
            justify-content: center;
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }

        .dropdown-section-title {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .product-card-mini {
            padding: 0.4rem;
        }

        .product-thumb {
            width: 50px;
            height: 50px;
        }

        .product-thumb-placeholder {
            width: 50px;
            height: 50px;
        }

        .product-name-mini {
            font-size: 0.8rem;
        }

        .product-price-mini .price-new {
            font-size: 0.85rem;
        }

        /* Hide dropdowns on hover for mobile - use click instead */
        .mega-menu .menu-item:not(.mobile-open):hover .mega-dropdown {
            max-height: 0;
            opacity: 0;
            padding: 0;
        }

        /* Ensure mobile-open state takes precedence */
        .mega-menu .menu-item.mobile-open .mega-dropdown {
            max-height: 2000px !important;
            opacity: 1 !important;
            padding: 0.5rem !important;
        }
    }

    /* RTL Support */
    [dir="rtl"] .mega-dropdown,
    html[dir="rtl"] .mega-dropdown,
    body[dir="rtl"] .mega-dropdown {
        left: auto;
        right: 0;
    }

    [dir="rtl"] .product-card-mini:hover,
    html[dir="rtl"] .product-card-mini:hover,
    body[dir="rtl"] .product-card-mini:hover {
        transform: translateX(-5px);
    }

    [dir="rtl"] .btn-view-all-products:hover i,
    html[dir="rtl"] .btn-view-all-products:hover i,
    body[dir="rtl"] .btn-view-all-products:hover i {
        transform: translateX(-5px);
    }

    /* RTL: Arrow rotation for collapsed state */
    @media (max-width: 991px) {
        [dir="rtl"] .mega-menu .menu-item:not(.mobile-open) .menu-link i,
        html[lang="ar"] .mega-menu .menu-item:not(.mobile-open) .menu-link i {
            transform: rotate(90deg);
        }
    }
</style>

<script>
// Mobile menu dropdown toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.mega-menu .menu-item.has-dropdown');

    function isMobile() {
        return window.innerWidth <= 991;
    }

    menuItems.forEach(item => {
        const link = item.querySelector('.menu-link');

        link.addEventListener('click', function(e) {
            if (isMobile()) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open items
                menuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('mobile-open');
                    }
                });

                // Toggle current item
                item.classList.toggle('mobile-open');
            }
        });
    });

    // Reset on resize
    window.addEventListener('resize', function() {
        if (!isMobile()) {
            menuItems.forEach(item => {
                item.classList.remove('mobile-open');
            });
        }
    });
});
</script>
