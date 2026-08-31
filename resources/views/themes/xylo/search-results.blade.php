@extends('themes.xylo.layouts.master')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    /* Desktop/Mobile visibility */
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

    /* ================================
       Mobile Search Results Styles
       ================================ */

    .mobile-search-page {
        min-height: 100vh;
        background: #f8f9fa;
    }

    /* Mobile Search Header */
    .mobile-search-header {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 20px 16px;
        color: white;
    }

    .mobile-search-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .mobile-search-query {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 600;
        margin: 0 4px;
    }

    .mobile-search-count {
        font-size: 13px;
        margin-top: 10px;
        opacity: 0.95;
    }

    /* Mobile Search Content */
    .mobile-search-content {
        padding: 16px;
        padding-bottom: 80px;
    }

    /* Mobile Product Grid */
    .mobile-products-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .mobile-product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .mobile-product-image {
        position: relative;
        padding-top: 100%;
        background: #f5f5f5;
        overflow: hidden;
    }

    .mobile-product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mobile-product-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        z-index: 2;
    }

    .mobile-product-info {
        padding: 12px;
    }

    .mobile-product-name {
        font-size: 13px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 36px;
        line-height: 1.4;
    }

    .mobile-product-name a {
        color: inherit;
        text-decoration: none;
    }

    .mobile-product-price {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
    }

    .mobile-price-current {
        font-size: 16px;
        font-weight: 700;
        color: var(--main-color);
    }

    .mobile-price-original {
        font-size: 12px;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .mobile-product-btn {
        width: 100%;
        background: var(--main-color);
        color: white;
        border: none;
        padding: 8px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    /* Mobile Empty State */
    .mobile-empty-search {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        margin-top: 20px;
    }

    .mobile-empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 16px;
        background: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: #999;
    }

    .mobile-empty-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #212529;
    }

    .mobile-empty-text {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .mobile-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--main-color);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    /* Mobile Pagination */
    .mobile-pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .mobile-search-header {
            padding: 16px 12px;
        }

        .mobile-search-title {
            font-size: 16px;
        }

        .mobile-search-query {
            font-size: 14px;
        }

        .mobile-search-content {
            padding: 12px;
        }

        .mobile-products-grid {
            gap: 10px;
        }

        .mobile-product-info {
            padding: 10px;
        }

        .mobile-product-name {
            font-size: 12px;
            min-height: 34px;
        }

        .mobile-price-current {
            font-size: 14px;
        }

        .mobile-product-btn {
            padding: 7px;
            font-size: 11px;
        }
    }
<style>
    /* Search Results Page Modern Design */
    .search-results-page {
        min-height: 100vh;
        padding: 40px 0 30px;
        margin-bottom: 0;
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
    }

    /* Search Header */
    .search-header {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 0 0 30px 30px;
        box-shadow: 0 10px 40px color-mix(in srgb, var(--main-color) 25%, transparent);
    }

    .search-header-content {
        text-align: center;
        color: #ffffff;
    }

    .search-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #ffffff;
    }

    .search-query {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 18px;
        font-weight: 600;
        margin: 0 8px;
        backdrop-filter: blur(10px);
    }

    .search-count {
        font-size: 16px;
        margin-top: 16px;
        opacity: 0.95;
        font-weight: 500;
    }

    .search-count strong {
        font-weight: 700;
        font-size: 18px;
    }

    /* Product Grid Modern */
    .products-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 28px;
        margin-top: 30px;
    }

    .product-card-modern {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .product-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px color-mix(in srgb, var(--main-color) 20%, rgba(0, 0, 0, 0.15));
        border-color: var(--main-color);
    }

    .product-image-wrapper {
        position: relative;
        padding-top: 100%;
        background: #f8fafc;
        overflow: hidden;
    }

    .product-image-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card-modern:hover .product-image-wrapper img {
        transform: scale(1.08);
    }

    .product-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        z-index: 2;
    }

    .product-info-modern {
        padding: 20px;
    }

    .product-name-modern {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
        min-height: 48px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .product-name-modern a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .product-name-modern a:hover {
        color: var(--main-color);
    }

    .product-description-modern {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 14px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.6;
        min-height: 42px;
    }

    .product-price-modern {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .price-current {
        font-size: 22px;
        font-weight: 700;
        color: var(--main-color);
    }

    .price-original {
        font-size: 15px;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .product-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view-product {
        flex: 1;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px color-mix(in srgb, var(--main-color) 30%, transparent);
    }

    .btn-view-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px color-mix(in srgb, var(--main-color) 40%, transparent);
        color: #ffffff;
    }

    .btn-view-product i {
        font-size: 12px;
    }

    /* Empty State */
    .empty-search-results {
        text-align: center;
        padding: 80px 20px;
        max-width: 500px;
        margin: 0 auto 30px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: #94a3b8;
    }

    .empty-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .empty-description {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .btn-back-home {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        padding: 14px 32px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px color-mix(in srgb, var(--main-color) 30%, transparent);
    }

    .btn-back-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px color-mix(in srgb, var(--main-color) 40%, transparent);
        color: #ffffff;
    }

    /* Pagination Container */
    .pagination-container {
        margin-top: 50px;
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .products-grid-modern {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }
    }

    @media (max-width: 768px) {
        .search-header {
            padding: 30px 0;
            margin-bottom: 30px;
        }

        .search-title {
            font-size: 24px;
        }

        .search-query {
            font-size: 16px;
        }

        .products-grid-modern {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }

        .product-info-modern {
            padding: 14px;
        }

        .product-name-modern {
            font-size: 14px;
            min-height: 42px;
        }

        .product-description-modern {
            font-size: 12px;
        }

        .price-current {
            font-size: 18px;
        }

        .empty-icon {
            width: 90px;
            height: 90px;
            font-size: 40px;
        }

        .empty-title {
            font-size: 22px;
        }
    }

    /* RTL Support */
    [dir="rtl"] .product-badge,
    html[dir="rtl"] .product-badge {
        right: auto;
        left: 12px;
    }

    [dir="rtl"] .btn-back-home i:first-child,
    html[dir="rtl"] .btn-back-home i:first-child {
        transform: scaleX(-1);
    }
</style>
@endsection

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="search-results-page">
    {{-- Search Header --}}
    <div class="search-header">
        <div class="container">
            <div class="search-header-content">
                <h1 class="search-title">
                    {{ __('store.search.search_results_for') }}
                    <span class="search-query">"{{ $query }}"</span>
                </h1>
                <p class="search-count">
                    @if($products->total() > 0)
                        <strong>{{ $products->total() }}</strong> {{ __('store.search.found_products') }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        @if($products->count() > 0)
            {{-- Products Grid --}}
            <div class="products-grid-modern">
                @foreach($products as $product)
                    <div class="product-card-modern">
                        {{-- Product Image --}}
                        <div class="product-image-wrapper">
                            @php
                                $finalImageUrl = store_image(optional($product->thumbnail)->image_url ?? 'default-thumbnail.jpg');
                            @endphp
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ optional($product->translation)->name ?? 'Product' }}"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=No+Image';">

                            @if(optional($product->primaryVariant)->discount_price)
                                @php
                                    $discountPercent = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                                @endphp
                                <div class="product-badge">-{{ $discountPercent }}%</div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="product-info-modern">
                            <h3 class="product-name-modern">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    {{ optional($product->translation)->name ?? __('store.common.no_name') }}
                                </a>
                            </h3>

                            <p class="product-description-modern">
                                {{ Str::limit(optional($product->translation)->description ?? '', 80) }}
                            </p>

                            @if($product->primaryVariant)
                                <div class="product-price-modern">
                                    @if($product->primaryVariant->discount_price)
                                        <span class="price-current">
                                            {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->discount_price), 2) }}
                                        </span>
                                        <span class="price-original">
                                            {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}
                                        </span>
                                    @else
                                        <span class="price-current">
                                            {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="product-actions">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn-view-product">
                                    <span>{{ __('store.common.view_details') ?? 'View Details' }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-container">
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-search-results">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2 class="empty-title">{{ __('store.search.no_results') }}</h2>
                <p class="empty-description">
                    {{ __('store.search.try_different_keywords') }}
                </p>
                <a href="{{ route('xylo.home') }}" class="btn-back-home">
                    <i class="fas fa-home"></i>
                    <span>{{ __('store.search.back_to_home') }}</span>
                </a>
            </div>
        @endif
    </div>
</div>
</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only">
    <div class="mobile-search-page">

        {{-- Mobile Search Header --}}
        <div class="mobile-search-header">
            <div class="mobile-search-title">
                {{ __('store.search.search_results_for') }}
                <span class="mobile-search-query">"{{ $query }}"</span>
            </div>
            @if($products->total() > 0)
                <div class="mobile-search-count">
                    <strong>{{ $products->total() }}</strong> {{ __('store.search.found_products') }}
                </div>
            @endif
        </div>

        {{-- Mobile Search Content --}}
        <div class="mobile-search-content">

            @if($products->count() > 0)
                {{-- Mobile Products Grid --}}
                <div class="mobile-products-grid">
                    @foreach($products as $product)
                        <div class="mobile-product-card">
                            {{-- Product Image --}}
                            <div class="mobile-product-image">
                                @php
                                    $finalImageUrl = store_image(optional($product->thumbnail)->image_url ?? 'default-thumbnail.jpg');
                                @endphp
                                <img src="{{ $finalImageUrl }}"
                                     alt="{{ optional($product->translation)->name ?? 'Product' }}"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x300?text=No+Image';">

                                @if(optional($product->primaryVariant)->discount_price)
                                    @php
                                        $discountPercent = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                                    @endphp
                                    <div class="mobile-product-badge">-{{ $discountPercent }}%</div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="mobile-product-info">
                                <h3 class="mobile-product-name">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        {{ optional($product->translation)->name ?? __('store.common.no_name') }}
                                    </a>
                                </h3>

                                @if($product->primaryVariant)
                                    <div class="mobile-product-price">
                                        @if($product->primaryVariant->discount_price)
                                            <span class="mobile-price-current">
                                                {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->discount_price), 2) }}
                                            </span>
                                            <span class="mobile-price-original">
                                                {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}
                                            </span>
                                        @else
                                            <span class="mobile-price-current">
                                                {{ currency_symbol() }}{{ number_format(convert_price($product->primaryVariant->price), 2) }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <a href="{{ route('product.show', $product->slug) }}" class="mobile-product-btn">
                                    <span>{{ __('store.common.view_details') ?? 'View' }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile Pagination --}}
                <div class="mobile-pagination">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            @else
                {{-- Mobile Empty State --}}
                <div class="mobile-empty-search">
                    <div class="mobile-empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="mobile-empty-title">{{ __('store.search.no_results') }}</h2>
                    <p class="mobile-empty-text">
                        {{ __('store.search.try_different_keywords') }}
                    </p>
                    <a href="{{ route('xylo.home') }}" class="mobile-empty-btn">
                        <i class="fas fa-home"></i>
                        <span>{{ __('store.search.back_to_home') }}</span>
                    </a>
                </div>
            @endif

        </div>

    </div>
</div>
{{-- END MOBILE VERSION --}}

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Smooth scroll on page load
    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
@endsection
