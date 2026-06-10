@extends('themes.xylo.layouts.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    .shop-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
        padding: 3rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 30px 30px;
    }

    .shop-header h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }

    .shop-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin: 0.5rem 0 0 0;
    }

    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filter-section::-webkit-scrollbar {
        width: 6px;
    }

    .filter-section::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .filter-section::-webkit-scrollbar-thumb {
        background: var(--main-color);
        border-radius: 10px;
    }

    .filter-group {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-title i {
        color: var(--main-color);
    }

    .form-check {
        margin-bottom: 1rem;
        padding-left: 0;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 0.75rem;
        border: 2px solid #ddd;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--main-color);
        border-color: var(--main-color);
    }

    .form-check-label {
        font-size: 0.95rem;
        color: #555;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-count {
        color: #999;
        font-size: 0.85rem;
        margin-left: auto;
    }

    .price-range-display {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 1rem;
        font-weight: 600;
        color: var(--main-color);
    }

    .range-slider {
        position: relative;
        height: 40px;
    }

    .range-slider input[type="range"] {
        position: absolute;
        width: 100%;
        height: 6px;
        background: transparent;
        pointer-events: none;
        -webkit-appearance: none;
    }

    .range-slider input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--main-color);
        cursor: pointer;
        pointer-events: all;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .range-slider input[type="range"]::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--main-color);
        cursor: pointer;
        pointer-events: all;
        border: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .products-toolbar {
        background: white;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .results-count {
        font-size: 1rem;
        color: #666;
        font-weight: 500;
    }

    .results-count strong {
        color: var(--main-color);
        font-weight: 700;
    }

    .mobile-filter-btn {
        background: var(--main-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        display: none;
    }

    @media (max-width: 991px) {
        .mobile-filter-btn {
            display: block;
        }

        .filter-section {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 350px;
            height: 100vh;
            z-index: 9999;
            transition: left 0.3s ease;
            max-height: 100vh;
        }

        .filter-section.show {
            left: 0;
        }

        .filter-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            display: none;
        }

        .filter-overlay.show {
            display: block;
        }
    }

    .close-filter {
        display: none;
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--main-color);
        color: white;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        font-size: 1.2rem;
        cursor: pointer;
    }

    @media (max-width: 991px) {
        .close-filter {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    /* Mobile Responsive Enhancements */
    @media (max-width: 768px) {
        .shop-header {
            padding: 2rem 0;
            margin-bottom: 1.5rem;
            border-radius: 0 0 20px 20px;
        }

        .shop-header h1 {
            font-size: 1.5rem;
        }

        .shop-header h1 i {
            display: none;
        }

        .shop-header p {
            font-size: 0.9rem;
        }

        .products-toolbar {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .results-count {
            font-size: 0.85rem;
        }

        .mobile-filter-btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .filter-section {
            padding: 1.5rem;
            border-radius: 0;
        }

        .filter-group {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .filter-title {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .price-range-display {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .paginations {
            margin-top: 2rem !important;
        }

        .main-shop {
            padding-top: 1rem !important;
            padding-bottom: 2rem !important;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .shop-header {
            padding: 1.5rem 0;
            margin-bottom: 1rem;
            border-radius: 0 0 15px 15px;
        }

        .shop-header h1 {
            font-size: 1.25rem;
        }

        .shop-header p {
            font-size: 0.8rem;
        }

        .products-toolbar {
            padding: 0.75rem;
            flex-direction: column;
            gap: 0.75rem;
        }

        .results-count {
            font-size: 0.8rem;
            text-align: center;
        }

        .mobile-filter-btn {
            width: 100%;
            padding: 0.6rem;
            font-size: 0.8rem;
        }

        .filter-section {
            padding: 1rem;
            width: 90%;
        }

        .filter-title {
            font-size: 0.95rem;
        }

        .form-check {
            margin-bottom: 0.75rem;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-right: 0.5rem;
        }

        .form-check-label {
            font-size: 0.85rem;
        }

        .filter-count {
            font-size: 0.75rem;
        }
    }

    /* ==========================================
       DESKTOP/MOBILE VISIBILITY TOGGLES
       ========================================== */
    .desktop-only {
        display: block;
    }

    .mobile-only {
        display: none;
    }

    @media (max-width: 768px) {
        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: block !important;
        }
    }

    /* ==========================================
       MOBILE SHOP STYLES
       ========================================== */
    .mobile-shop-header {
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-light) 100%);
        padding: 1.25rem 1rem;
        text-align: center;
    }

    .mobile-shop-header h1 {
        color: white;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
    }

    .mobile-shop-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.8rem;
        margin: 0;
    }

    .mobile-shop-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        background: white;
        border-bottom: 1px solid #eee;
        position: sticky;
        top: 60px;
        z-index: 100;
    }

    .mobile-results {
        font-size: 0.85rem;
        color: #666;
    }

    .mobile-results .count {
        font-weight: 700;
        color: var(--main-color);
    }

    .mobile-filter-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--main-color);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .mobile-products-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        padding: 1rem;
        background: #f8f9fa;
    }

    .mobile-pagination {
        padding: 1.5rem 1rem;
        display: flex;
        justify-content: center;
        background: #f8f9fa;
    }

    /* Mobile Filter Bottom Sheet */
    .mobile-filter-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .mobile-filter-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .mobile-filter-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        max-height: 85vh;
        background: white;
        border-radius: 20px 20px 0 0;
        z-index: 9999;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .mobile-filter-sheet.active {
        transform: translateY(0);
    }

    .filter-sheet-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #eee;
        flex-shrink: 0;
    }

    .filter-sheet-header h3 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #333;
    }

    .filter-sheet-header h3 i {
        color: var(--main-color);
    }

    .close-sheet {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #f0f0f0;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filter-sheet-content {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem 0;
    }

    .mobile-filter-group {
        border-bottom: 1px solid #f0f0f0;
    }

    .filter-group-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        cursor: pointer;
    }

    .filter-group-header span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-group-header i:first-child {
        color: var(--main-color);
        width: 20px;
    }

    .filter-group-header .fa-chevron-down {
        transition: transform 0.3s ease;
        font-size: 0.75rem;
        color: #999;
    }

    .filter-group-header.active .fa-chevron-down {
        transform: rotate(180deg);
    }

    .filter-group-content {
        display: none;
        padding: 0 1.25rem 1rem;
    }

    .filter-group-content.active {
        display: block;
    }

    .mobile-filter-option {
        display: flex;
        align-items: center;
        padding: 0.6rem 0;
        cursor: pointer;
        gap: 0.75rem;
    }

    .mobile-filter-option input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--main-color);
    }

    .mobile-filter-option .option-text {
        flex: 1;
        font-size: 0.85rem;
        color: #444;
    }

    .mobile-filter-option .option-count {
        font-size: 0.75rem;
        color: #999;
    }

    .mobile-price-display {
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        color: var(--main-color);
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .mobile-price-sliders {
        position: relative;
        height: 30px;
    }

    .mobile-price-sliders input[type="range"] {
        position: absolute;
        width: 100%;
        height: 4px;
        background: transparent;
        pointer-events: none;
        -webkit-appearance: none;
    }

    .mobile-price-sliders input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--main-color);
        cursor: pointer;
        pointer-events: all;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .filter-sheet-footer {
        display: flex;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-top: 1px solid #eee;
        background: white;
        flex-shrink: 0;
    }

    .clear-filters-btn {
        flex: 1;
        padding: 0.85rem;
        border: 2px solid #ddd;
        background: white;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .apply-filters-btn {
        flex: 2;
        padding: 0.85rem;
        border: none;
        background: var(--main-color);
        color: white;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Small Mobile Adjustments */
    @media (max-width: 480px) {
        .mobile-shop-header {
            padding: 1rem 0.75rem;
        }

        .mobile-shop-header h1 {
            font-size: 1.1rem;
        }

        .mobile-shop-header p {
            font-size: 0.75rem;
        }

        .mobile-shop-toolbar {
            padding: 0.6rem 0.75rem;
        }

        .mobile-results {
            font-size: 0.8rem;
        }

        .mobile-filter-trigger {
            padding: 0.4rem 0.85rem;
            font-size: 0.75rem;
        }

        .mobile-products-grid {
            gap: 0.5rem;
            padding: 0.75rem;
        }

        .filter-sheet-header {
            padding: 0.85rem 1rem;
        }

        .filter-sheet-header h3 {
            font-size: 0.95rem;
        }

        .filter-group-header {
            padding: 0.85rem 1rem;
            font-size: 0.85rem;
        }

        .filter-group-content {
            padding: 0 1rem 0.85rem;
        }

        .mobile-filter-option {
            padding: 0.5rem 0;
        }

        .mobile-filter-option input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        .mobile-filter-option .option-text {
            font-size: 0.8rem;
        }

        .filter-sheet-footer {
            padding: 0.85rem 1rem;
        }

        .clear-filters-btn,
        .apply-filters-btn {
            padding: 0.75rem;
            font-size: 0.8rem;
        }
    }
</style>
@endsection
@section('content')
    @php $currency = activeCurrency(); @endphp

    {{-- ========================================== --}}
    {{-- DESKTOP VERSION --}}
    {{-- ========================================== --}}
    <div class="desktop-only">
        {{-- Shop Header --}}
        <div class="shop-header">
            <div class="container">
                <h1><i class="fas fa-store me-3"></i>{{ __('store.shop.title') }}</h1>
                <p>{{ __('store.shop.subtitle') }}</p>
            </div>
        </div>

        <section class="products-home py-4 mb-5 main-shop">
            <div class="container">
                <div class="row">
                    {{-- Sidebar Filters --}}
                    <aside class="col-lg-3">
                        <div class="filter-overlay" id="filterOverlay"></div>
                        <div class="filter-section" id="filterSidebar">
                            <button class="close-filter" id="closeFilter"><i class="fas fa-times"></i></button>

                            {{-- Brands Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-title"><i class="fas fa-tag"></i>{{ __('store.shop.brands') }}</h5>
                                @foreach($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="checkbox" name="brand[]"
                                           value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                    <label class="form-check-label" for="brand-{{ $brand->id }}">
                                        {{ mb_convert_case($brand->translation->name ?? $brand->slug, MB_CASE_TITLE, "UTF-8") }}
                                        <span class="filter-count">({{ $brand->products_count }})</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Categories Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-title"><i class="fas fa-th-large"></i>{{ __('store.shop.categories') }}</h5>
                                @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="checkbox" name="category[]"
                                           value="{{ $category->id }}" id="category-{{ $category->id }}">
                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                        {{ mb_convert_case($category->translation->name ?? $category->slug, MB_CASE_TITLE, "UTF-8") }}
                                        <span class="filter-count">({{ $category->products_count }})</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Price Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-title"><i class="fas fa-dollar-sign"></i>{{ __('store.shop.price') }}</h5>
                                <div class="price-range-display">
                                    {{ $currency->symbol }}<span id="minPriceText">0</span> - {{ $currency->symbol }}<span id="maxPriceText">1000</span>
                                </div>
                                <div class="range-slider">
                                    <input type="range" name="price_min" id="minPrice" min="0" max="1000" value="0" step="10">
                                    <input type="range" name="price_max" id="maxPrice" min="0" max="1000" value="1000" step="10">
                                </div>
                            </div>

                            {{-- Colors Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-title"><i class="fas fa-palette"></i>{{ __('store.shop.colors') }}</h5>
                                @foreach(['red', 'black'] as $color)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="checkbox" name="color[]"
                                           value="{{ strtolower($color) }}" id="color-{{ $color }}">
                                    <label class="form-check-label" for="color-{{ $color }}">
                                        {{ __('store.shop.' . strtolower($color)) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Size Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-title"><i class="fas fa-ruler"></i>{{ __('store.shop.size') }}</h5>
                                @foreach(['M' => 'M', 'L' => 'L'] as $key => $size)
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="checkbox" name="size[]"
                                           value="{{ $key }}" id="size-{{ $key }}">
                                    <label class="form-check-label" for="size-{{ $key }}">
                                        {{ __('store.shop.' . $key) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>

                    {{-- Products Section --}}
                    <div class="col-lg-9">
                        {{-- Toolbar --}}
                        <div class="products-toolbar">
                            <div class="results-count">
                                <strong>{{ $products->total() }}</strong> {{ __('store.shop.products_found') }}
                            </div>
                            <button class="mobile-filter-btn" id="mobileFilterBtn">
                                <i class="fas fa-filter me-2"></i>{{ __('store.shop.filters') }}
                            </button>
                        </div>

                        {{-- Product Grid --}}
                        <div class="row" id="productList">
                            @include('themes.xylo.partials.product-list')
                        </div>

                        {{-- Pagination --}}
                        <div class="paginations d-flex justify-content-center align-items-center mt-5">
                            {{ $products->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- ========================================== --}}
    {{-- MOBILE VERSION --}}
    {{-- ========================================== --}}
    <div class="mobile-only">
        {{-- Mobile Shop Header --}}
        <div class="mobile-shop-header">
            <h1>{{ __('store.shop.title') }}</h1>
            <p>{{ __('store.shop.subtitle') }}</p>
        </div>

        {{-- Mobile Toolbar --}}
        <div class="mobile-shop-toolbar">
            <div class="mobile-results">
                <span class="count">{{ $products->total() }}</span> {{ __('store.shop.products_found') }}
            </div>
            <button class="mobile-filter-trigger" id="mobileFilterTrigger">
                <i class="fas fa-sliders-h"></i>
                <span>{{ __('store.shop.filters') }}</span>
            </button>
        </div>

        {{-- Mobile Product Grid --}}
        <div class="mobile-products-grid" id="mobileProductList">
            @foreach($products as $product)
                @include('themes.xylo.partials.product-card', ['product' => $product])
            @endforeach
        </div>

        {{-- Mobile Pagination --}}
        <div class="mobile-pagination">
            {{ $products->links('vendor.pagination.custom') }}
        </div>

        {{-- Mobile Filter Bottom Sheet --}}
        <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
        <div class="mobile-filter-sheet" id="mobileFilterSheet">
            <div class="filter-sheet-header">
                <h3><i class="fas fa-filter"></i> {{ __('store.shop.filters') }}</h3>
                <button class="close-sheet" id="closeFilterSheet"><i class="fas fa-times"></i></button>
            </div>

            <div class="filter-sheet-content">
                {{-- Categories --}}
                <div class="mobile-filter-group">
                    <div class="filter-group-header" data-toggle="categories">
                        <span><i class="fas fa-th-large"></i> {{ __('store.shop.categories') }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="filter-group-content" id="filter-categories">
                        @foreach($categories as $category)
                        <label class="mobile-filter-option">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}" class="mobile-filter-input">
                            <span class="option-text">{{ mb_convert_case($category->translation->name ?? $category->slug, MB_CASE_TITLE, "UTF-8") }}</span>
                            <span class="option-count">({{ $category->products_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Brands --}}
                <div class="mobile-filter-group">
                    <div class="filter-group-header" data-toggle="brands">
                        <span><i class="fas fa-tag"></i> {{ __('store.shop.brands') }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="filter-group-content" id="filter-brands">
                        @foreach($brands as $brand)
                        <label class="mobile-filter-option">
                            <input type="checkbox" name="brand[]" value="{{ $brand->id }}" class="mobile-filter-input">
                            <span class="option-text">{{ mb_convert_case($brand->translation->name ?? $brand->slug, MB_CASE_TITLE, "UTF-8") }}</span>
                            <span class="option-count">({{ $brand->products_count }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div class="mobile-filter-group">
                    <div class="filter-group-header" data-toggle="price">
                        <span><i class="fas fa-dollar-sign"></i> {{ __('store.shop.price') }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="filter-group-content" id="filter-price">
                        <div class="mobile-price-display">
                            {{ $currency->symbol }}<span id="mobileMinPrice">0</span> - {{ $currency->symbol }}<span id="mobileMaxPrice">1000</span>
                        </div>
                        <div class="mobile-price-sliders">
                            <input type="range" id="mobileMinSlider" min="0" max="1000" value="0" step="10">
                            <input type="range" id="mobileMaxSlider" min="0" max="1000" value="1000" step="10">
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-sheet-footer">
                <button class="clear-filters-btn" id="clearMobileFilters">
                    <i class="fas fa-undo"></i> {{ __('store.shop.clear_all') ?? 'Clear All' }}
                </button>
                <button class="apply-filters-btn" id="applyMobileFilters">
                    {{ __('store.shop.apply_filters') ?? 'Apply Filters' }}
                </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Mobile Filter Toggle
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');
    const closeFilter = document.getElementById('closeFilter');

    function toggleMobileFilter() {
        filterSidebar.classList.toggle('show');
        filterOverlay.classList.toggle('show');
    }

    if (mobileFilterBtn) {
        mobileFilterBtn.addEventListener('click', toggleMobileFilter);
    }

    if (closeFilter) {
        closeFilter.addEventListener('click', toggleMobileFilter);
    }

    if (filterOverlay) {
        filterOverlay.addEventListener('click', toggleMobileFilter);
    }

    // Price Range Functionality
    const minSlider = document.getElementById('minPrice');
    const maxSlider = document.getElementById('maxPrice');
    const minPriceText = document.getElementById('minPriceText');
    const maxPriceText = document.getElementById('maxPriceText');

    function updatePriceDisplay() {
        let minVal = parseInt(minSlider.value);
        let maxVal = parseInt(maxSlider.value);

        if (minVal > maxVal) {
            [minVal, maxVal] = [maxVal, minVal];
        }

        minPriceText.textContent = minVal;
        maxPriceText.textContent = maxVal;

        // Trigger the filter request after price changes
        sendFilterRequest();
    }

    minSlider.addEventListener('input', updatePriceDisplay);
    maxSlider.addEventListener('input', updatePriceDisplay);

    // Function to send filters including price
    function sendFilterRequest() {
        let url = new URL("{{ route('shop.index') }}", window.location.origin);
        let params = new URLSearchParams();

        // Include all checked filter inputs
        document.querySelectorAll('.filter-input:checked').forEach(checked => {
            params.append(checked.name, checked.value);
        });

        // Include price range
        let minVal = parseInt(minSlider.value);
        let maxVal = parseInt(maxSlider.value);

        if (minVal > maxVal) {
            [minVal, maxVal] = [maxVal, minVal];
        }

        params.append('price_min', minVal);
        params.append('price_max', maxVal);

        url.search = params.toString();

        fetch(url, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('productList').innerHTML = html;
            // Close mobile filter after applying filters
            if (window.innerWidth < 992) {
                toggleMobileFilter();
            }
        });
    }

    // Trigger filter when other inputs change
    document.querySelectorAll('.filter-input').forEach(input => {
        input.addEventListener('change', sendFilterRequest);
    });

    // Optional: Initial load
    updatePriceDisplay();
</script>

<script>
function addToCart(productId) {
    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        toastr.success("{{ session('success') }}", data.message, {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
        updateCartCount(data.cart, data.cart_count);
    })
    .catch(error => console.error("Error:", error));
}

function updateCartCount(cart) {
    let totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById("cart-count").textContent = totalCount;
}

// ==========================================
// MOBILE FILTER FUNCTIONALITY
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterTrigger = document.getElementById('mobileFilterTrigger');
    const mobileFilterOverlay = document.getElementById('mobileFilterOverlay');
    const mobileFilterSheet = document.getElementById('mobileFilterSheet');
    const closeFilterSheet = document.getElementById('closeFilterSheet');
    const applyMobileFilters = document.getElementById('applyMobileFilters');
    const clearMobileFilters = document.getElementById('clearMobileFilters');

    // Toggle filter sheet
    function toggleMobileFilterSheet() {
        mobileFilterOverlay.classList.toggle('active');
        mobileFilterSheet.classList.toggle('active');
        document.body.style.overflow = mobileFilterSheet.classList.contains('active') ? 'hidden' : '';
    }

    if (mobileFilterTrigger) {
        mobileFilterTrigger.addEventListener('click', toggleMobileFilterSheet);
    }

    if (closeFilterSheet) {
        closeFilterSheet.addEventListener('click', toggleMobileFilterSheet);
    }

    if (mobileFilterOverlay) {
        mobileFilterOverlay.addEventListener('click', toggleMobileFilterSheet);
    }

    // Toggle filter groups (accordion)
    document.querySelectorAll('.filter-group-header').forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle');
            const content = document.getElementById('filter-' + targetId);

            this.classList.toggle('active');
            content.classList.toggle('active');
        });
    });

    // Mobile price sliders
    const mobileMinSlider = document.getElementById('mobileMinSlider');
    const mobileMaxSlider = document.getElementById('mobileMaxSlider');
    const mobileMinPrice = document.getElementById('mobileMinPrice');
    const mobileMaxPrice = document.getElementById('mobileMaxPrice');

    function updateMobilePriceDisplay() {
        if (mobileMinSlider && mobileMaxSlider) {
            let minVal = parseInt(mobileMinSlider.value);
            let maxVal = parseInt(mobileMaxSlider.value);

            if (minVal > maxVal) {
                [minVal, maxVal] = [maxVal, minVal];
            }

            mobileMinPrice.textContent = minVal;
            mobileMaxPrice.textContent = maxVal;
        }
    }

    if (mobileMinSlider) {
        mobileMinSlider.addEventListener('input', updateMobilePriceDisplay);
    }
    if (mobileMaxSlider) {
        mobileMaxSlider.addEventListener('input', updateMobilePriceDisplay);
    }

    // Apply mobile filters
    if (applyMobileFilters) {
        applyMobileFilters.addEventListener('click', function() {
            let url = new URL("{{ route('shop.index') }}", window.location.origin);
            let params = new URLSearchParams();

            // Get checked filters
            document.querySelectorAll('.mobile-filter-input:checked').forEach(input => {
                params.append(input.name, input.value);
            });

            // Get price range
            if (mobileMinSlider && mobileMaxSlider) {
                let minVal = parseInt(mobileMinSlider.value);
                let maxVal = parseInt(mobileMaxSlider.value);
                if (minVal > maxVal) {
                    [minVal, maxVal] = [maxVal, minVal];
                }
                params.append('price_min', minVal);
                params.append('price_max', maxVal);
            }

            // Navigate to filtered URL
            url.search = params.toString();
            window.location.href = url.toString();
        });
    }

    // Clear mobile filters
    if (clearMobileFilters) {
        clearMobileFilters.addEventListener('click', function() {
            document.querySelectorAll('.mobile-filter-input:checked').forEach(input => {
                input.checked = false;
            });
            if (mobileMinSlider) mobileMinSlider.value = 0;
            if (mobileMaxSlider) mobileMaxSlider.value = 1000;
            updateMobilePriceDisplay();
        });
    }

    // Open first filter group by default
    const firstHeader = document.querySelector('.filter-group-header');
    if (firstHeader) {
        firstHeader.classList.add('active');
        const firstContent = document.getElementById('filter-' + firstHeader.getAttribute('data-toggle'));
        if (firstContent) firstContent.classList.add('active');
    }
});
</script>
@endsection
