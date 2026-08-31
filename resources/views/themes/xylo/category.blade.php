@extends('themes.xylo.layouts.master')

@section('title', $category->translation->name)

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    /* Category Page Modern Design */
    .category-page {
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
        min-height: 100vh;
        padding-bottom: 60px;
    }

    /* Modern Breadcrumb */
    .modern-breadcrumb {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 24px 0;
        margin-bottom: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .breadcrumb-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .breadcrumb-modern li {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
    }

    .breadcrumb-modern li a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 6px 12px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .breadcrumb-modern li a:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .breadcrumb-modern li.active {
        color: #ffffff;
        font-weight: 600;
    }

    .breadcrumb-separator {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Category Header */
    .category-header {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 60px 0 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .category-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .category-header-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
        text-align: center;
    }

    .category-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 36px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .category-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 12px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .category-description {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        max-width: 600px;
        margin: 0 auto;
    }

    .products-count {
        margin-top: 16px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    /* Filter Section */
    .filters-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
    }

    .filters-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f1f5f9;
    }

    .filters-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .filters-title i {
        color: var(--main-color);
    }

    .clear-filters-btn {
        background: transparent;
        color: var(--main-color);
        border: 2px solid var(--main-color);
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .clear-filters-btn:hover {
        background: var(--main-color);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin: 0;
    }

    .filter-input,
    .filter-select {
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #ffffff;
        color: #1e293b;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: var(--main-color);
        box-shadow: 0 0 0 4px rgba(132, 204, 22, 0.1);
    }

    .filter-btn {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.3);
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(132, 204, 22, 0.4);
    }

    /* Products Grid */
    .products-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 28px;
        margin-bottom: 40px;
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
        box-shadow: 0 12px 35px rgba(132, 204, 22, 0.2);
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

    .wishlist-btn-modern {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
        color: #64748b;
    }

    .wishlist-btn-modern:hover {
        background: #ffffff;
        color: #ef4444;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .wishlist-btn-modern.active {
        background: #ef4444;
        color: #ffffff;
    }

    .product-info-modern {
        padding: 20px;
    }

    .product-rating-modern {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .stars {
        display: flex;
        gap: 2px;
        color: #fbbf24;
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
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.3);
    }

    .btn-view-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(132, 204, 22, 0.4);
        color: #ffffff;
    }

    .btn-add-cart {
        width: 48px;
        height: 48px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--main-color);
        font-size: 18px;
    }

    .btn-add-cart:hover {
        background: var(--main-color);
        border-color: var(--main-color);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.3);
    }

    /* Empty State */
    .empty-products {
        text-align: center;
        padding: 80px 20px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
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

    .btn-back-shop {
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
        box-shadow: 0 6px 20px rgba(132, 204, 22, 0.3);
    }

    .btn-back-shop:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(132, 204, 22, 0.4);
        color: #ffffff;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .products-grid-modern {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }
    }

    @media (max-width: 768px) {
        .category-header {
            padding: 40px 0 30px;
        }

        .category-title {
            font-size: 28px;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            font-size: 28px;
        }

        .filters-form {
            grid-template-columns: 1fr;
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

        .modern-breadcrumb {
            padding: 16px 0;
        }

        .breadcrumb-modern li {
            font-size: 12px;
        }

        .breadcrumb-modern li a {
            padding: 4px 8px;
        }

        .filters-section {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .filters-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .filters-title {
            font-size: 16px;
        }

        .filter-input,
        .filter-select {
            padding: 10px 12px;
            font-size: 13px;
        }

        .filter-btn {
            width: 100%;
            padding: 10px 20px;
        }

        .category-description {
            font-size: 14px;
        }

        .products-count {
            font-size: 12px;
        }

        .btn-view-product {
            padding: 10px 14px;
            font-size: 12px;
        }

        .btn-add-cart {
            width: 42px;
            height: 42px;
            font-size: 16px;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .category-page {
            padding-bottom: 40px;
        }

        .modern-breadcrumb {
            padding: 12px 0;
        }

        .breadcrumb-modern {
            gap: 8px;
        }

        .breadcrumb-modern li {
            font-size: 11px;
            gap: 8px;
        }

        .breadcrumb-modern li a {
            padding: 3px 6px;
            font-size: 11px;
        }

        .breadcrumb-separator {
            font-size: 10px;
        }

        .category-header {
            padding: 30px 0 20px;
            margin-bottom: 20px;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            font-size: 22px;
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .category-title {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .category-description {
            font-size: 13px;
        }

        .products-count {
            font-size: 11px;
            margin-top: 12px;
        }

        .filters-section {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .filters-header {
            margin-bottom: 14px;
            padding-bottom: 12px;
        }

        .filters-title {
            font-size: 14px;
        }

        .clear-filters-btn {
            padding: 6px 14px;
            font-size: 11px;
        }

        .filter-label {
            font-size: 11px;
        }

        .filter-input,
        .filter-select {
            padding: 8px 10px;
            font-size: 12px;
            border-radius: 8px;
        }

        .filter-btn {
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 8px;
        }

        .products-grid-modern {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .product-card-modern {
            border-radius: 12px;
        }

        .wishlist-btn-modern {
            width: 32px;
            height: 32px;
            top: 8px;
            left: 8px;
        }

        .product-badge {
            top: 8px;
            right: 8px;
            padding: 4px 10px;
            font-size: 10px;
        }

        .product-info-modern {
            padding: 10px;
        }

        .product-rating-modern {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .product-name-modern {
            font-size: 12px;
            min-height: 36px;
            margin-bottom: 6px;
        }

        .product-price-modern {
            margin-bottom: 10px;
        }

        .price-current {
            font-size: 14px;
        }

        .price-original {
            font-size: 11px;
        }

        .product-actions {
            flex-direction: column;
            gap: 6px;
        }

        .btn-view-product {
            padding: 8px 12px;
            font-size: 11px;
            border-radius: 8px;
        }

        .btn-add-cart {
            width: 100%;
            height: 36px;
            border-radius: 8px;
            font-size: 14px;
        }

        .empty-products {
            padding: 50px 16px;
            border-radius: 12px;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 18px;
            margin-bottom: 12px;
        }

        .empty-description {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-back-shop {
            padding: 12px 24px;
            font-size: 14px;
        }

        .pagination-container {
            margin-top: 24px;
        }
    }

    /* RTL Support */
    [dir="rtl"] .breadcrumb-modern,
    html[dir="rtl"] .breadcrumb-modern {
        flex-direction: row;
    }

    [dir="rtl"] .product-badge,
    html[dir="rtl"] .product-badge {
        right: auto;
        left: 12px;
    }

    [dir="rtl"] .wishlist-btn-modern,
    html[dir="rtl"] .wishlist-btn-modern {
        left: auto;
        right: 12px;
    }

    [dir="rtl"] .btn-back-shop i:first-child,
    html[dir="rtl"] .btn-back-shop i:first-child {
        transform: scaleX(-1);
    }
</style>
@endsection

@section('content')
<div class="category-page">
    {{-- Breadcrumb --}}
    <div class="modern-breadcrumb">
        <div class="container">
            <ol class="breadcrumb-modern">
                <li>
                    <a href="{{ route('xylo.home') }}">
                        <i class="fas fa-home"></i> {{ __('store.category.home') }}
                    </a>
                </li>
                <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                @foreach($breadcrumbs as $index => $crumb)
                    <li class="{{ $loop->last ? 'active' : '' }}">
                        @if(!$loop->last)
                            <a href="{{ route('category.show', $crumb->slug) }}">{{ $crumb->translation->name }}</a>
                        @else
                            {{ $crumb->translation->name }}
                        @endif
                    </li>
                    @if(!$loop->last)
                        <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                    @endif
                @endforeach
            </ol>
        </div>
    </div>

    {{-- Category Header --}}
    <div class="category-header">
        <div class="container">
            <div class="category-header-content">
                <div class="category-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h1 class="category-title">{{ $category->translation->name }}</h1>
                @if($category->translation->description)
                    <p class="category-description">{{ strip_tags($category->translation->description) }}</p>
                @endif
                <p class="products-count">
                    <i class="fas fa-box-open me-2"></i>{{ $products->total() }} {{ __('store.category.products_available') }}
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        {{-- Filters Section --}}
        <div class="filters-section">
            <div class="filters-header">
                <h3 class="filters-title">
                    <i class="fas fa-filter"></i>
                    {{ __('store.category.filter_products') }}
                </h3>
                @if(request()->hasAny(['min_price', 'max_price', 'sort']))
                    <a href="{{ route('category.show', $category->slug) }}" class="clear-filters-btn">
                        <i class="fas fa-times me-1"></i> {{ __('store.category.clear_filters') }}
                    </a>
                @endif
            </div>

            <form method="GET" action="{{ route('category.show', $category->slug) }}" class="filters-form">
                <div class="filter-group">
                    <label class="filter-label">{{ __('store.category.min_price') }}</label>
                    <input type="number"
                           name="min_price"
                           class="filter-input"
                           placeholder="0"
                           value="{{ request('min_price') }}"
                           min="0"
                           step="0.01">
                </div>

                <div class="filter-group">
                    <label class="filter-label">{{ __('store.category.max_price') }}</label>
                    <input type="number"
                           name="max_price"
                           class="filter-input"
                           placeholder="1000"
                           value="{{ request('max_price') }}"
                           min="0"
                           step="0.01">
                </div>

                <div class="filter-group">
                    <label class="filter-label">{{ __('store.category.sort_by') }}</label>
                    <select name="sort" class="filter-select">
                        <option value="">{{ __('store.category.default_sorting') }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('store.category.newest') }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('store.category.price_low_high') }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('store.category.price_high_low') }}</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('store.category.top_rated') }}</option>
                    </select>
                </div>

                <button type="submit" class="filter-btn">
                    <i class="fas fa-search"></i>
                    {{ __('store.category.apply_filters') }}
                </button>
            </form>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="products-grid-modern">
                @foreach($products as $product)
                    <div class="product-card-modern">
                        {{-- Product Image --}}
                        <div class="product-image-wrapper">
                            @php
                                $finalImageUrl = store_image(optional($product->thumbnail)->image_url ?? 'default-thumbnail.jpg');
                            @endphp
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $finalImageUrl }}"
                                     alt="{{ optional($product->translation)->name ?? 'Product' }}"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400?text=No+Image';">
                            </a>

                            @if(optional($product->primaryVariant)->discount_price)
                                @php
                                    $discountPercent = round((($product->primaryVariant->price - $product->primaryVariant->discount_price) / $product->primaryVariant->price) * 100);
                                @endphp
                                <div class="product-badge">-{{ $discountPercent }}%</div>
                            @endif

                            <button class="wishlist-btn-modern" data-product-id="{{ $product->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>

                        {{-- Product Info --}}
                        <div class="product-info-modern">
                            <div class="product-rating-modern">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($product->reviews_avg_rating ?? 0))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span>({{ $product->reviews_count ?? 0 }})</span>
                            </div>

                            <h3 class="product-name-modern">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    {{ optional($product->translation)->name ?? __('store.common.no_name') }}
                                </a>
                            </h3>

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
                                <button class="btn-add-cart" onclick="addToCart({{ $product->id }})" title="{{ __('store.common.add_to_cart') }}">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-container">
                {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-products">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h2 class="empty-title">{{ __('store.category.no_products_found') }}</h2>
                <p class="empty-description">
                    {{ __('store.category.no_products_description') }}
                </p>
                <a href="{{ route('xylo.home') }}" class="btn-back-shop">
                    <i class="fas fa-home"></i>
                    <span>{{ __('store.category.back_to_home') }}</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Add to Cart Function
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
        toastr.success(data.message, '', {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        });
        updateCartCount(data.cart, data.cart_count);
    })
    .catch(error => {
        toastr.error("{{ __('store.cart.error') }}", '', {
            closeButton: true,
            positionClass: "toast-top-right",
        });
    });
}

function updateCartCount(cart) {
    let totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
    const cartBadge = document.querySelector('.badge-count');
    if (cartBadge) {
        cartBadge.textContent = totalCount;
    }
}

// Wishlist Function
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wishlist-btn-modern').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');

            fetch('/customer/wishlist', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '/customer/login';
                } else if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            })
            .then(data => {
                if (data?.message) {
                    toastr.success(data.message, '', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000
                    });
                    this.classList.toggle('active');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection
