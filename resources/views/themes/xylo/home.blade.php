@extends('themes.xylo.layouts.master')

@section('content')
@php
    $currency = activeCurrency();
@endphp

{{-- =====================================================
     DESKTOP VERSION - Hidden on mobile devices
     ===================================================== --}}

{{-- Hero Promotional Banners Section (Desktop) --}}
<section class="promotional-banners-section desktop-only" style="min-height: 600px;">
    <div class="promo-slider-wrapper">
        <div class="promo-slider" id="promoSlider">
            @foreach ($banners as $index => $banner)
            @php
                $finalBannerUrl = store_image(optional($banner->translation)->image_url ?? 'default.jpg');
            @endphp
            <div class="promo-slide {{ $index === 0 ? 'active' : '' }}">
                <div class="promo-slide-bg">
                    <img src="{{ $finalBannerUrl }}"
                         alt="{{ $banner->translation ? $banner->translation->title : $banner->title }}"
                         onerror="this.src='https://via.placeholder.com/1920x600?text=No+Image'">
                    <div class="promo-overlay"></div>
                </div>
                <div class="container">
                    <div class="promo-content-wrapper">
                        <div class="promo-content">
                            <span class="promo-badge">
                                <i class="fas fa-fire me-2"></i>{{ __('store.home.new_arrival') }}
                            </span>
                            <h1 class="promo-title">
                                {{ $banner->translation ? $banner->translation->title : $banner->title }}
                            </h1>
                            <div class="promo-description">
                                {!! $banner->translation ? $banner->translation->description : __('store.home.banner_subtitle') !!}
                            </div>
                            <div class="promo-actions">
                                <a href="{{ route('shop.index') }}" class="btn-promo-primary">
                                    <i class="fas fa-shopping-bag me-2"></i>{{ __('store.home.shop_now') }}
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                                <a href="{{ route('shop.index') }}" class="btn-promo-secondary">
                                    {{ __('store.home.explore_more') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Slider Navigation -->
        @if(count($banners) > 1)
        <button class="promo-nav promo-prev" onclick="changeSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="promo-nav promo-next" onclick="changeSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        @endif
    </div>
</section>

{{-- Features Bar (Desktop) --}}
<section class="features-bar desktop-only">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="feature-text">
                        <h6>{{ __('store.home.free_shipping') }}</h6>
                        <p>{{ __('store.home.free_shipping_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <div class="feature-text">
                        <h6>{{ __('store.home.easy_returns') }}</h6>
                        <p>{{ __('store.home.easy_returns_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="feature-text">
                        <h6>{{ __('store.home.secure_payment') }}</h6>
                        <p>{{ __('store.home.secure_payment_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="feature-text">
                        <h6>{{ __('store.home.support_247') }}</h6>
                        <p>{{ __('store.home.support_247_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section (Desktop) --}}
<section class="categories-section desktop-only">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('store.home.shop_by_category') }}</h2>
            <a href="{{ route('shop.index') }}" class="view-all-link">
                {{ __('store.home.view_all') }} <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="categories-grid">
            @foreach($categories->take(8) as $category)
            <div class="category-card">
                <a href="{{ route('category.show', $category->slug) }}">
                    <div class="category-image">
                        @php
                            $finalCatUrl = store_image(optional($category->translation)->image_url ?? 'default.jpg');
                        @endphp
                        <img src="{{ $finalCatUrl }}"
                             alt="{{ $category->translation->name ?? 'Category' }}">
                        <div class="category-overlay">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <h5 class="category-name">{{ $category->translation->name ?? __('store.header.no_translation') }}</h5>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Flash Deals Section (Desktop) --}}
<section class="flash-deals-section desktop-only">
    <div class="container">
        <div class="flash-deals-header">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-bolt text-warning me-2"></i>{{ __('store.home.flash_deals') }}
                </h2>
                <div class="countdown-timer" id="countdown">
                    <div class="time-box">
                        <span class="time-value" id="hours">00</span>
                        <span class="time-label">{{ __('store.home.hours') }}</span>
                    </div>
                    <span class="separator">:</span>
                    <div class="time-box">
                        <span class="time-value" id="minutes">00</span>
                        <span class="time-label">{{ __('store.home.minutes') }}</span>
                    </div>
                    <span class="separator">:</span>
                    <div class="time-box">
                        <span class="time-value" id="seconds">00</span>
                        <span class="time-label">{{ __('store.home.seconds') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="products-slider-container">
            <div class="products-slider">
                @foreach ($products->take(8) as $product)
                <div class="product-slide">
                    @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
                </div>
                @endforeach
            </div>
            <button class="slider-nav slider-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-nav slider-next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

{{-- Promotional Banners (Desktop) --}}
<section class="promo-banners-section desktop-only">
    <div class="container">
        <div class="row g-4">
            @php
                $largeCard = $promoCards->where('size', 'large')->first();
                $smallCards = $promoCards->where('size', 'small');
            @endphp

            @if($largeCard && $largeCard->translation)
            <div class="col-lg-6">
                <div class="promo-banner promo-banner-1" style="background-image: url('{{ $largeCard->translation->image_url }}');">
                    <div class="promo-content">
                        @if($largeCard->translation->badge_text)
                        <span class="promo-label">{{ $largeCard->translation->badge_text }}</span>
                        @endif
                        <h3>{{ $largeCard->translation->title }}</h3>
                        @if($largeCard->translation->button_text && $largeCard->translation->button_url)
                        <a href="{{ $largeCard->translation->button_url }}" class="promo-btn">{{ $largeCard->translation->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($smallCards->isNotEmpty())
            <div class="col-lg-6">
                <div class="row g-4">
                    @foreach($smallCards as $index => $card)
                    @if($card->translation)
                    <div class="col-12">
                        <div class="promo-banner promo-banner-{{ $index + 2 }}" style="background-image: url('{{ $card->translation->image_url }}');">
                            <div class="promo-content">
                                @if($card->translation->badge_text)
                                <span class="promo-label">{{ $card->translation->badge_text }}</span>
                                @endif
                                <h4>{{ $card->translation->title }}</h4>
                                @if($card->translation->button_text && $card->translation->button_url)
                                <a href="{{ $card->translation->button_url }}" class="promo-btn">
                                    {{ $card->translation->button_text }} <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Trending Products (Desktop) --}}
<section class="trending-products-section desktop-only">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('store.home.trending_products') }}</h2>
            <a href="{{ route('shop.index') }}" class="view-all-link">
                {{ __('store.home.view_all') }} <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="products-grid">
            @foreach ($products as $product)
            <div class="product-grid-item">
                @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- =====================================================
     MOBILE VERSION - Hidden on desktop devices
     Fully optimized for touch devices and small screens
     ===================================================== --}}

{{-- Mobile Hero Section --}}
<section class="mobile-hero mobile-only">
    <div class="mobile-hero-slider" id="mobileHeroSlider">
        @foreach ($banners as $index => $banner)
        @php
            $finalBannerUrl = store_image(optional($banner->translation)->image_url ?? 'default.jpg');
        @endphp
        <div class="mobile-hero-slide {{ $index === 0 ? 'active' : '' }}">
            <div class="mobile-hero-image">
                <img src="{{ $finalBannerUrl }}"
                     alt="{{ $banner->translation ? $banner->translation->title : $banner->title }}"
                     onerror="this.src='https://via.placeholder.com/800x400?text=No+Image'">
                <div class="mobile-hero-overlay"></div>
            </div>
            <div class="mobile-hero-content">
                <span class="mobile-hero-badge">
                    <i class="fas fa-fire"></i> {{ __('store.home.new_arrival') }}
                </span>
                <h2 class="mobile-hero-title">
                    {{ $banner->translation ? $banner->translation->title : $banner->title }}
                </h2>
                <p class="mobile-hero-desc">
                    {{ Str::limit(strip_tags($banner->translation ? $banner->translation->description : ''), 80) }}
                </p>
                <a href="{{ route('shop.index') }}" class="mobile-hero-btn">
                    <i class="fas fa-shopping-bag"></i> {{ __('store.home.shop_now') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @if(count($banners) > 1)
    <div class="mobile-hero-dots">
        @foreach ($banners as $index => $banner)
        <span class="mobile-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
        @endforeach
    </div>
    @endif
</section>

{{-- Mobile Features Bar - Horizontal Scroll Icons --}}
<section class="mobile-features mobile-only">
    <div class="mobile-features-scroll">
        <div class="mobile-feature-item">
            <div class="mobile-feature-icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <span>{{ __('store.home.free_shipping') }}</span>
        </div>
        <div class="mobile-feature-item">
            <div class="mobile-feature-icon">
                <i class="fas fa-undo-alt"></i>
            </div>
            <span>{{ __('store.home.easy_returns') }}</span>
        </div>
        <div class="mobile-feature-item">
            <div class="mobile-feature-icon">
                <i class="fas fa-lock"></i>
            </div>
            <span>{{ __('store.home.secure_payment') }}</span>
        </div>
        <div class="mobile-feature-item">
            <div class="mobile-feature-icon">
                <i class="fas fa-headset"></i>
            </div>
            <span>{{ __('store.home.support_247') }}</span>
        </div>
    </div>
</section>

{{-- Mobile Categories - 2x2 Grid with See All --}}
<section class="mobile-categories mobile-only">
    <div class="mobile-section-header">
        <h3>{{ __('store.home.shop_by_category') }}</h3>
        <a href="{{ route('shop.index') }}" class="mobile-see-all">
            {{ __('store.home.view_all') }} <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <div class="mobile-categories-grid">
        @foreach($categories->take(4) as $category)
        <a href="{{ route('category.show', $category->slug) }}" class="mobile-category-card">
            @php
                $finalCatUrl = store_image(optional($category->translation)->image_url ?? 'default.jpg');
            @endphp
            <div class="mobile-category-img">
                <img src="{{ $finalCatUrl }}" alt="{{ $category->translation->name ?? 'Category' }}">
            </div>
            <span class="mobile-category-name">{{ $category->translation->name ?? __('store.header.no_translation') }}</span>
        </a>
        @endforeach
    </div>
    @if($categories->count() > 4)
    <div class="mobile-categories-more">
        @foreach($categories->skip(4)->take(4) as $category)
        <a href="{{ route('category.show', $category->slug) }}" class="mobile-category-pill">
            {{ $category->translation->name ?? __('store.header.no_translation') }}
        </a>
        @endforeach
    </div>
    @endif
</section>

{{-- Mobile Flash Deals - Horizontal Scroll --}}
<section class="mobile-flash-deals mobile-only">
    <div class="mobile-section-header mobile-flash-header">
        <div class="mobile-flash-title">
            <i class="fas fa-bolt"></i>
            <h3>{{ __('store.home.flash_deals') }}</h3>
        </div>
        <div class="mobile-countdown" id="mobileCountdown">
            <span class="mobile-time" id="mobileHours">00</span>:
            <span class="mobile-time" id="mobileMinutes">00</span>:
            <span class="mobile-time" id="mobileSeconds">00</span>
        </div>
    </div>
    <div class="mobile-products-scroll">
        @foreach ($products->take(8) as $product)
        <div class="mobile-product-card-wrapper">
            @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
        </div>
        @endforeach
    </div>
</section>

{{-- Mobile Promo Banners - Vertical Stack --}}
<section class="mobile-promos mobile-only">
    @php
        $largeCard = $promoCards->where('size', 'large')->first();
        $smallCards = $promoCards->where('size', 'small');
    @endphp

    @if($largeCard && $largeCard->translation)
    <a href="{{ $largeCard->translation->button_url ?? '#' }}" class="mobile-promo-card mobile-promo-large">
        <div class="mobile-promo-bg" style="background-image: url('{{ $largeCard->translation->image_url }}');">
            <div class="mobile-promo-content">
                @if($largeCard->translation->badge_text)
                <span class="mobile-promo-badge">{{ $largeCard->translation->badge_text }}</span>
                @endif
                <h4>{{ $largeCard->translation->title }}</h4>
                @if($largeCard->translation->button_text)
                <span class="mobile-promo-cta">{{ $largeCard->translation->button_text }} <i class="fas fa-arrow-right"></i></span>
                @endif
            </div>
        </div>
    </a>
    @endif

    @if($smallCards->isNotEmpty())
    <div class="mobile-promos-row">
        @foreach($smallCards->take(2) as $card)
        @if($card->translation)
        <a href="{{ $card->translation->button_url ?? '#' }}" class="mobile-promo-card mobile-promo-small">
            <div class="mobile-promo-bg" style="background-image: url('{{ $card->translation->image_url }}');">
                <div class="mobile-promo-content">
                    @if($card->translation->badge_text)
                    <span class="mobile-promo-badge">{{ $card->translation->badge_text }}</span>
                    @endif
                    <h5>{{ Str::limit($card->translation->title, 30) }}</h5>
                </div>
            </div>
        </a>
        @endif
        @endforeach
    </div>
    @endif
</section>

{{-- Mobile Trending Products - 2 Column Grid --}}
<section class="mobile-trending mobile-only">
    <div class="mobile-section-header">
        <h3>{{ __('store.home.trending_products') }}</h3>
        <a href="{{ route('shop.index') }}" class="mobile-see-all">
            {{ __('store.home.view_all') }} <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <div class="mobile-products-grid">
        @foreach ($products->take(6) as $product)
        <div class="mobile-product-item">
            @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
        </div>
        @endforeach
    </div>
    <div class="mobile-load-more">
        <a href="{{ route('shop.index') }}" class="mobile-load-more-btn">
            {{ __('store.home.view_all') }} {{ __('store.home.trending_products') }}
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
:root {
    --primary-color: var(--main-color);
    --secondary-color: var(--main-color-light);
    --dark-color: #1e293b;
    --light-color: #ffffff;
    --text-muted: #64748b;
    --border-color: #e2e8f0;
    --gradient-primary: linear-gradient(135deg, var(--main-color), var(--main-color-light));
}

/* Promotional Banners Section */
.promotional-banners-section {
    position: relative;
    overflow: hidden;
    margin-bottom: 0;
    background: #f8f9fa;
}

.promo-slider-wrapper {
    position: relative;
    width: 100%;
    height: 600px;
    min-height: 600px;
}

.promo-slider {
    position: relative;
    width: 100%;
    height: 100%;
}

.promo-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.6s ease-in-out;
    z-index: 0;
}

.promo-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
}

.promo-slide-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.promo-slide-bg img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.promo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 100%);
    z-index: 1;
}

.promo-content-wrapper {
    position: relative;
    z-index: 2;
    height: 600px;
    display: flex;
    align-items: center;
}

.promo-content {
    max-width: 700px;
    color: white;
}

.promo-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 24px;
    letter-spacing: 1.5px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.promo-title {
    font-size: 4rem;
    font-weight: 900;
    color: white;
    line-height: 1.1;
    margin-bottom: 20px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.promo-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 32px;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.promo-description p {
    margin: 0;
}

.promo-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-promo-primary,
.btn-promo-secondary {
    padding: 16px 36px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}

.btn-promo-primary {
    background: white;
    color: var(--dark-color);
    border: none;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.btn-promo-primary:hover {
    background: var(--main-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
}

.btn-promo-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-promo-secondary:hover {
    background: white;
    color: var(--dark-color);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(255, 255, 255, 0.3);
}

/* Slider Navigation */
.promo-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    color: white;
    font-size: 1.25rem;
}

.promo-nav:hover {
    background: white;
    color: var(--dark-color);
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.promo-prev {
    left: 30px;
}

.promo-next {
    right: 30px;
}

/* Features Bar */
.features-bar {
    padding: 40px 0;
    background: var(--light-color);
    border-bottom: 1px solid var(--border-color);
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ffffff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(132, 204, 22, 0.25);
}

.feature-text h6 {
    margin: 0 0 5px;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
}

.feature-text p {
    margin: 0;
    font-size: 0.85rem;
    color: var(--text-muted);
}

/* Section Headers */
.categories-section,
.flash-deals-section,
.trending-products-section {
    padding: 80px 0;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all-link:hover {
    color: var(--secondary-color);
    transform: translateX(5px);
}

.view-all-link i {
    transition: transform 0.3s ease;
}

.view-all-link:hover i {
    transform: translateX(3px);
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
}

.category-card {
    text-align: center;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-10px);
}

.category-card a {
    text-decoration: none;
}

.category-image {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 15px;
    background: var(--secondary-color);
    padding-top: 100%;
}

.category-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-image img {
    transform: scale(1.1);
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-overlay {
    opacity: 0.95;
}

.category-overlay i {
    color: #ffffff;
    font-size: 2rem;
}

.category-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0;
}

/* Flash Deals */
.flash-deals-section {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%);
}

.flash-deals-header .section-header {
    align-items: center;
}

.countdown-timer {
    display: flex;
    gap: 10px;
    align-items: center;
}

.time-box {
    background: var(--gradient-primary);
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 12px;
    text-align: center;
    min-width: 70px;
    box-shadow: 0 4px 12px rgba(132, 204, 22, 0.25);
}

.time-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
}

.time-label {
    display: block;
    font-size: 0.7rem;
    opacity: 0.8;
}

.separator {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
}

/* Products Slider */
.products-slider-container {
    position: relative;
}

.products-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 20px;
    scrollbar-width: none;
}

.products-slider::-webkit-scrollbar {
    display: none;
}

.product-slide {
    flex: 0 0 280px;
}

.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: var(--light-color);
    border: 2px solid var(--border-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.slider-prev {
    left: -25px;
}

.slider-next {
    right: -25px;
}

.slider-nav:hover {
    background: var(--accent-color);
    border-color: var(--accent-color);
    color: var(--dark-color);
}

/* Promo Banners */
.promo-banners-section {
    padding: 40px 0 80px;
}

.promo-banner {
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    min-height: 250px;
    display: flex;
    align-items: center;
    padding: 40px;
    background-size: cover;
    background-position: center;
}

.promo-banner-1 {
    background-image:
        linear-gradient(135deg, rgba(255, 193, 7, 0.85) 0%, rgba(255, 152, 0, 0.85) 100%),
        url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800&q=80');
    min-height: 520px;
}

.promo-banner-2 {
    background-image:
        linear-gradient(135deg, rgba(14, 14, 14, 0.7) 0%, rgba(52, 52, 52, 0.7) 100%),
        url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80');
}

.promo-banner-3 {
    background-image:
        linear-gradient(135deg, rgba(255, 87, 87, 0.75) 0%, rgba(255, 107, 107, 0.75) 100%),
        url('https://images.unsplash.com/photo-1601924638867-3a6de6b7a500?w=800&q=80');
}

.promo-content {
    position: relative;
    z-index: 2;
}

.promo-label {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--light-color);
    margin-bottom: 15px;
}

.promo-banner h3,
.promo-banner h4 {
    color: var(--light-color);
    font-weight: 700;
    margin-bottom: 20px;
}

.promo-btn,
.promo-link {
    color: var(--light-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.promo-btn {
    display: inline-block;
    background: var(--light-color);
    color: var(--dark-color);
    padding: 12px 30px;
    border-radius: 50px;
}

.promo-btn:hover {
    background: var(--dark-color);
    color: var(--light-color);
    transform: translateY(-3px);
}

.promo-link:hover {
    text-decoration: underline;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    max-width: 100%;
}

.products-grid .product-grid-item {
    max-width: 280px;
    justify-self: center;
    width: 100%;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
    }

    .countdown-timer {
        flex-wrap: wrap;
    }
}

/* RTL Support */
[dir="rtl"] .hero-content,
html[dir="rtl"] .hero-content,
body[dir="rtl"] .hero-content {
    text-align: right;
}

[dir="rtl"] .hero-section .row,
html[dir="rtl"] .hero-section .row,
body[dir="rtl"] .hero-section .row {
    flex-direction: row-reverse;
}

[dir="rtl"] .hero-section::before,
html[dir="rtl"] .hero-section::before,
body[dir="rtl"] .hero-section::before {
    right: auto;
    left: -10%;
}

[dir="rtl"] .hero-section::after,
html[dir="rtl"] .hero-section::after,
body[dir="rtl"] .hero-section::after {
    left: auto;
    right: -5%;
}

[dir="rtl"] .hero-subtitle,
html[dir="rtl"] .hero-subtitle,
body[dir="rtl"] .hero-subtitle {
    margin-right: 0;
    margin-left: auto;
}

[dir="rtl"] .hero-buttons,
html[dir="rtl"] .hero-buttons,
body[dir="rtl"] .hero-buttons {
    justify-content: flex-end;
}

[dir="rtl"] .btn-hero-primary i,
html[dir="rtl"] .btn-hero-primary i,
body[dir="rtl"] .btn-hero-primary i {
    margin-right: 0;
    margin-left: 8px;
}

[dir="rtl"] .feature-item,
html[dir="rtl"] .feature-item,
body[dir="rtl"] .feature-item {
    flex-direction: row-reverse;
    text-align: right;
}

[dir="rtl"] .section-header,
html[dir="rtl"] .section-header,
body[dir="rtl"] .section-header {
    flex-direction: row-reverse;
}

[dir="rtl"] .view-all-link,
html[dir="rtl"] .view-all-link,
body[dir="rtl"] .view-all-link {
    text-align: left;
}

[dir="rtl"] .view-all-link i,
html[dir="rtl"] .view-all-link i,
body[dir="rtl"] .view-all-link i {
    margin-left: 0;
    margin-right: 5px;
    transform: scaleX(-1);
}

[dir="rtl"] .category-card,
html[dir="rtl"] .category-card,
body[dir="rtl"] .category-card {
    text-align: right;
}

[dir="rtl"] .product-card,
html[dir="rtl"] .product-card,
body[dir="rtl"] .product-card {
    text-align: right;
}

[dir="rtl"] .product-actions,
html[dir="rtl"] .product-actions,
body[dir="rtl"] .product-actions {
    flex-direction: row-reverse;
}

[dir="rtl"] .deal-box,
html[dir="rtl"] .deal-box,
body[dir="rtl"] .deal-box {
    text-align: right;
}

[dir="rtl"] .countdown-timer,
html[dir="rtl"] .countdown-timer,
body[dir="rtl"] .countdown-timer {
    direction: ltr;
}

/* Product card image alignment for RTL */
[dir="rtl"] .product-card .product-img,
html[dir="rtl"] .product-card .product-img,
body[dir="rtl"] .product-card .product-img {
    text-align: center;
}

[dir="rtl"] .product-card .wishlist-btn,
html[dir="rtl"] .product-card .wishlist-btn,
body[dir="rtl"] .product-card .wishlist-btn {
    right: auto;
    left: 10px;
}

[dir="rtl"] .hero-image img,
html[dir="rtl"] .hero-image img,
body[dir="rtl"] .hero-image img {
    transform: scaleX(1);
}

/* ====================================
   COMPACT HOME PAGE OVERRIDES
   ==================================== */

/* Compact Hero Section */
.hero-section {
    padding: 30px 0 20px !important;
}

.hero-content {
    padding: 15px !important;
}

.hero-badge {
    padding: 4px 12px !important;
    font-size: 0.7rem !important;
    margin-bottom: 10px !important;
}

.hero-title {
    font-size: 2rem !important;
    margin-bottom: 10px !important;
}

.hero-subtitle {
    font-size: 0.9rem !important;
    margin-bottom: 15px !important;
}

.hero-buttons {
    gap: 10px !important;
}

.btn-hero-primary,
.btn-hero-outline {
    padding: 10px 20px !important;
    font-size: 0.85rem !important;
}

.hero-image {
    padding: 8px !important;
}

.hero-image img {
    max-height: 320px !important;
    border-radius: 12px !important;
}

/* Compact Features Bar */
.features-bar {
    padding: 24px 0 !important;
}

.feature-item {
    gap: 12px !important;
}

.feature-icon {
    width: 48px !important;
    height: 48px !important;
    border-radius: 12px !important;
}

.feature-icon i {
    font-size: 1.3rem !important;
}

.feature-text h6 {
    font-size: 0.9rem !important;
    margin-bottom: 4px !important;
}

.feature-text p {
    font-size: 0.75rem !important;
}

/* Compact Section Headers */
.section-header {
    margin-bottom: 20px !important;
}

.section-title {
    font-size: 1.6rem !important;
    margin-bottom: 8px !important;
}

.section-subtitle {
    font-size: 0.85rem !important;
}

/* Compact Categories */
.categories-grid {
    gap: 12px !important;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important;
}

.category-card {
    padding: 8px !important;
}

.category-image {
    padding-top: 100% !important;
    margin-bottom: 10px !important;
    border-radius: 12px !important;
}

.category-image img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.category-card h3 {
    font-size: 0.85rem !important;
    margin-top: 6px !important;
}

.category-card p {
    font-size: 0.7rem !important;
}

/* Compact Products Grid */
.products-grid {
    gap: 14px !important;
}

.product-card {
    padding: 10px !important;
    border-radius: 12px !important;
}

.product-card .product-image {
    height: 180px !important;
    border-radius: 10px !important;
    margin-bottom: 8px !important;
}

.product-card .product-badge {
    padding: 3px 8px !important;
    font-size: 0.65rem !important;
}

.product-card .wishlist-btn {
    width: 32px !important;
    height: 32px !important;
    font-size: 0.8rem !important;
}

.product-card .product-name {
    font-size: 0.85rem !important;
    margin-bottom: 5px !important;
}

.product-card .product-rating {
    font-size: 0.7rem !important;
    margin-bottom: 6px !important;
}

.product-card .product-price {
    font-size: 1rem !important;
    margin-bottom: 8px !important;
}

.product-card .btn-add-to-cart {
    padding: 7px 14px !important;
    font-size: 0.8rem !important;
}

/* Compact Products Grid - product-card-modern overrides */
.product-card-modern {
    padding: 0 !important;
    border-radius: 8px !important;
    overflow: hidden !important;
}

.product-card-modern .product-image-wrapper {
    margin: 0 !important;
    padding: 0 !important;
}

.product-card-modern .product-info-wrapper {
    margin: 0 !important;
}

/* Compact Why Choose Us */
.why-choose-us {
    padding: 30px 0 !important;
}

.why-item {
    padding: 16px !important;
}

.why-icon {
    width: 50px !important;
    height: 50px !important;
    margin-bottom: 10px !important;
}

.why-icon i {
    font-size: 1.4rem !important;
}

.why-item h5 {
    font-size: 1rem !important;
    margin-bottom: 6px !important;
}

.why-item p {
    font-size: 0.8rem !important;
}

/* iPad Pro and Tablet Responsive */
@media (max-width: 1199px) {
    .promo-content {
        max-width: 480px;
        padding: 0 15px;
    }

    .promo-title {
        font-size: 2rem !important;
    }

    .promo-description {
        font-size: 0.95rem !important;
    }

    .promo-nav {
        width: 48px;
        height: 48px;
        font-size: 1.1rem;
    }

    .promo-prev {
        left: 8px;
    }

    .promo-next {
        right: 8px;
    }

    .btn-promo-primary,
    .btn-promo-secondary {
        padding: 14px 28px !important;
        font-size: 0.95rem !important;
    }
}

/* iPad Mini and Small Tablets (768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .promo-slider-wrapper {
        height: 500px;
    }

    .promo-content-wrapper {
        height: 500px;
    }

    .promo-slide-bg img {
        object-fit: contain;
        max-height: 500px;
    }

    .promo-content {
        max-width: 420px;
        padding: 0 20px;
    }

    .promo-title {
        font-size: 1.75rem !important;
    }

    .promo-description {
        font-size: 0.9rem !important;
    }

    .promo-badge {
        font-size: 0.75rem !important;
        padding: 8px 16px !important;
    }

    .btn-promo-primary,
    .btn-promo-secondary {
        padding: 12px 24px !important;
        font-size: 0.9rem !important;
    }

    .promo-nav {
        width: 44px;
        height: 44px;
        font-size: 1rem;
    }

    /* Features Bar - Center aligned */
    .features-bar .row {
        justify-content: center;
    }

    .features-bar .col-lg-3 {
        display: flex;
        justify-content: center;
    }

    .feature-item {
        justify-content: center;
        text-align: center;
        flex-direction: column;
        max-width: 200px;
    }

    .feature-text {
        text-align: center;
    }

    /* Products Grid - 3 columns for iPad Mini */
    .products-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 16px;
        max-width: 100%;
    }

    .products-grid .product-grid-item {
        max-width: 100%;
        width: 100%;
    }

    /* Section spacing */
    .categories-section,
    .flash-deals-section,
    .trending-products-section {
        padding: 50px 0;
    }

    .section-title {
        font-size: 1.5rem;
    }
}

/* Mobile Responsive Compact */
@media (max-width: 768px) {
    .promo-slider-wrapper {
        height: 500px;
    }

    .promo-content-wrapper {
        height: 500px;
        padding: 20px 0;
    }

    .promo-title {
        font-size: 2rem !important;
    }

    .promo-description {
        font-size: 1rem !important;
    }

    .promo-badge {
        font-size: 0.75rem !important;
        padding: 8px 16px !important;
    }

    .btn-promo-primary,
    .btn-promo-secondary {
        padding: 12px 24px !important;
        font-size: 0.9rem !important;
    }

    .promo-nav {
        width: 44px;
        height: 44px;
        font-size: 1rem;
    }

    .promo-prev {
        left: 15px;
    }

    .promo-next {
        right: 15px;
    }

    .section-title {
        font-size: 1.3rem !important;
    }

    .feature-icon {
        width: 40px !important;
        height: 40px !important;
    }

    .feature-icon i {
        font-size: 1.1rem !important;
    }

    .feature-text h6 {
        font-size: 0.85rem !important;
    }

    .feature-text p {
        font-size: 0.7rem !important;
    }

    .product-card .product-image {
        height: 140px !important;
    }
}

@media (max-width: 480px) {
    .promo-slider-wrapper {
        height: 450px;
    }

    .promo-content-wrapper {
        height: 450px;
    }

    .promo-title {
        font-size: 1.75rem !important;
    }

    .promo-description {
        font-size: 0.9rem !important;
    }

    .promo-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-promo-primary,
    .btn-promo-secondary {
        width: 100%;
        justify-content: center;
    }

    .promo-nav {
        width: 40px;
        height: 40px;
    }
}

/* =====================================================
   MOBILE/DESKTOP VISIBILITY TOGGLES
   ===================================================== */

/* Desktop elements - hide on mobile */
.desktop-only {
    display: block !important;
}

/* Mobile elements - hide on desktop */
.mobile-only {
    display: none !important;
}

/* Switch visibility at 768px breakpoint */
@media (max-width: 768px) {
    .desktop-only {
        display: none !important;
    }

    .mobile-only {
        display: block !important;
    }

    /* Restore flex display for sections that need it */
    .mobile-promos.mobile-only {
        display: flex !important;
    }
}

/* =====================================================
   MOBILE VERSION STYLES
   Fully optimized for touch devices
   ===================================================== */

/* Mobile Hero Section */
.mobile-hero {
    position: relative;
    background: #f8fafc;
    overflow: hidden;
}

.mobile-hero-slider {
    position: relative;
    width: 100%;
    height: 320px;
}

.mobile-hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease;
}

.mobile-hero-slide.active {
    opacity: 1;
    visibility: visible;
}

.mobile-hero-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.mobile-hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mobile-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.6) 100%);
}

.mobile-hero-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px 16px;
    color: white;
    z-index: 2;
}

.mobile-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--main-color);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.mobile-hero-badge i {
    font-size: 0.65rem;
}

.mobile-hero-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 8px 0;
    line-height: 1.2;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.mobile-hero-desc {
    font-size: 0.85rem;
    margin: 0 0 12px 0;
    opacity: 0.9;
    line-height: 1.4;
}

.mobile-hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: var(--dark-color);
    padding: 12px 24px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.mobile-hero-btn:hover {
    background: var(--main-color);
    color: white;
    transform: translateY(-2px);
}

.mobile-hero-dots {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.mobile-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}

.mobile-dot.active {
    background: white;
    width: 24px;
    border-radius: 4px;
}

/* Mobile Features Bar */
.mobile-features {
    background: white;
    padding: 16px 0;
    border-bottom: 1px solid #e5e7eb;
    overflow: hidden;
}

.mobile-features-scroll {
    display: flex;
    gap: 12px;
    padding: 0 16px;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.mobile-features-scroll::-webkit-scrollbar {
    display: none;
}

.mobile-feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    min-width: 80px;
    text-align: center;
}

.mobile-feature-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(132, 204, 22, 0.25);
}

.mobile-feature-item span {
    font-size: 0.7rem;
    font-weight: 500;
    color: var(--dark-color);
    white-space: nowrap;
}

/* Mobile Section Headers */
.mobile-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 16px;
    margin-bottom: 16px;
}

.mobile-section-header h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.mobile-see-all {
    display: flex;
    align-items: center;
    gap: 4px;
    color: var(--main-color);
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
}

.mobile-see-all i {
    font-size: 0.7rem;
}

/* Mobile Categories */
.mobile-categories {
    padding: 24px 0;
    background: #f8fafc;
}

.mobile-categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 0 16px;
    margin-bottom: 12px;
}

.mobile-category-card {
    background: white;
    border-radius: 16px;
    padding: 12px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.mobile-category-card:active {
    transform: scale(0.98);
}

.mobile-category-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 10px;
    background: #f1f5f9;
}

.mobile-category-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.mobile-category-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--dark-color);
    text-align: center;
}

.mobile-categories-more {
    display: flex;
    gap: 8px;
    padding: 0 16px;
    overflow-x: auto;
    scrollbar-width: none;
}

.mobile-categories-more::-webkit-scrollbar {
    display: none;
}

.mobile-category-pill {
    display: inline-block;
    padding: 8px 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--dark-color);
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.3s ease;
}

.mobile-category-pill:active {
    background: var(--main-color);
    color: white;
    border-color: var(--main-color);
}

/* Mobile Flash Deals */
.mobile-flash-deals {
    padding: 24px 0;
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%);
}

.mobile-flash-header {
    flex-wrap: wrap;
    gap: 8px;
}

.mobile-flash-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.mobile-flash-title i {
    color: #f59e0b;
    font-size: 1.2rem;
}

.mobile-flash-title h3 {
    margin: 0;
}

.mobile-countdown {
    display: flex;
    align-items: center;
    gap: 2px;
    background: var(--main-color);
    padding: 6px 12px;
    border-radius: 8px;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
}

.mobile-time {
    min-width: 24px;
    text-align: center;
}

.mobile-products-scroll {
    display: flex;
    gap: 12px;
    padding: 0 16px;
    overflow-x: auto;
    scrollbar-width: none;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}

.mobile-products-scroll::-webkit-scrollbar {
    display: none;
}

.mobile-product-card-wrapper {
    flex: 0 0 160px;
    scroll-snap-align: start;
}

.mobile-product-card-wrapper .product-card {
    height: 100%;
}

/* Mobile Promo Banners */
.mobile-promos {
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.mobile-promo-card {
    display: block;
    text-decoration: none;
    border-radius: 16px;
    overflow: hidden;
}

.mobile-promo-bg {
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: flex-end;
}

.mobile-promo-large .mobile-promo-bg {
    min-height: 180px;
    background-color: #fbbf24;
}

.mobile-promo-small .mobile-promo-bg {
    min-height: 120px;
    background-color: #374151;
}

.mobile-promo-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 100%);
}

.mobile-promo-content {
    position: relative;
    z-index: 2;
    padding: 16px;
    width: 100%;
}

.mobile-promo-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(4px);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 600;
    color: white;
    margin-bottom: 8px;
}

.mobile-promo-content h4,
.mobile-promo-content h5 {
    color: white;
    margin: 0;
    font-weight: 700;
}

.mobile-promo-content h4 {
    font-size: 1.1rem;
}

.mobile-promo-content h5 {
    font-size: 0.9rem;
}

.mobile-promo-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 10px;
}

.mobile-promos-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

/* Mobile Trending Products */
.mobile-trending {
    padding: 24px 0 32px;
    background: white;
}

.mobile-products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 0 16px;
}

.mobile-product-item {
    width: 100%;
}

.mobile-product-item .product-card {
    height: 100%;
}

.mobile-load-more {
    padding: 20px 16px 0;
    text-align: center;
}

.mobile-load-more-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 24px;
    background: var(--main-color);
    color: white;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.mobile-load-more-btn:hover {
    background: var(--main-color-light);
    transform: translateY(-2px);
}

/* Mobile Product Card Overrides - product-card-modern */
@media (max-width: 768px) {
    /* Nuclear reset - remove ALL gaps */
    .mobile-product-item .product-card-modern *,
    .mobile-product-card-wrapper .product-card-modern * {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .mobile-product-item .product-card-modern,
    .mobile-product-card-wrapper .product-card-modern {
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0 !important;
    }

    .mobile-product-item .product-card-modern .product-image-wrapper,
    .mobile-product-card-wrapper .product-card-modern .product-image-wrapper {
        height: 140px !important;
        min-height: 140px !important;
        max-height: 140px !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .mobile-product-item .product-card-modern .product-image-wrapper > a,
    .mobile-product-card-wrapper .product-card-modern .product-image-wrapper > a {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .mobile-product-item .product-card-modern .product-image,
    .mobile-product-card-wrapper .product-card-modern .product-image {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .mobile-product-item .product-card-modern .product-info-wrapper,
    .mobile-product-card-wrapper .product-card-modern .product-info-wrapper {
        padding: 8px !important;
        margin: 0 !important;
        flex-grow: 0 !important;
    }

    .mobile-product-item .product-card-modern .product-rating,
    .mobile-product-card-wrapper .product-card-modern .product-rating {
        margin-bottom: 4px !important;
    }

    .mobile-product-item .product-card-modern .product-name,
    .mobile-product-card-wrapper .product-card-modern .product-name {
        font-size: 0.75rem !important;
        margin-bottom: 4px !important;
        line-height: 1.2 !important;
    }

    .mobile-product-item .product-card-modern .product-price-wrapper,
    .mobile-product-card-wrapper .product-card-modern .product-price-wrapper {
        margin-bottom: 6px !important;
    }

    .mobile-product-item .product-card-modern .btn-add-to-cart,
    .mobile-product-card-wrapper .product-card-modern .btn-add-to-cart {
        padding: 8px !important;
        font-size: 0.7rem !important;
    }

    /* Old product-card styles kept for backwards compatibility */
    .mobile-product-card-wrapper .product-card,
    .mobile-product-item .product-card {
        padding: 10px;
        border-radius: 12px;
    }

    .mobile-product-card-wrapper .product-card .product-img,
    .mobile-product-item .product-card .product-img {
        height: 130px;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .mobile-product-card-wrapper .product-card .product-name,
    .mobile-product-item .product-card .product-name {
        font-size: 0.8rem;
        -webkit-line-clamp: 2;
        margin-bottom: 4px;
    }

    .mobile-product-card-wrapper .product-card .product-price,
    .mobile-product-item .product-card .product-price {
        font-size: 0.95rem;
    }

    .mobile-product-card-wrapper .product-card .product-actions,
    .mobile-product-item .product-card .product-actions {
        gap: 6px;
    }

    .mobile-product-card-wrapper .product-card .btn-add-cart,
    .mobile-product-item .product-card .btn-add-cart {
        padding: 8px 12px;
        font-size: 0.75rem;
    }

    .mobile-product-card-wrapper .product-card .btn-quick-view,
    .mobile-product-item .product-card .btn-quick-view,
    .mobile-product-card-wrapper .product-card .btn-wishlist,
    .mobile-product-item .product-card .btn-wishlist {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
}

/* Small mobile adjustments */
@media (max-width: 380px) {
    .mobile-hero-slider {
        height: 280px;
    }

    .mobile-hero-title {
        font-size: 1.3rem;
    }

    .mobile-hero-desc {
        font-size: 0.8rem;
    }

    .mobile-hero-btn {
        padding: 10px 20px;
        font-size: 0.85rem;
    }

    .mobile-hero-dots {
        bottom: 12px;
    }

    .mobile-feature-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .mobile-category-img {
        width: 60px;
        height: 60px;
    }

    .mobile-section-header h3 {
        font-size: 1.05rem;
    }

    .mobile-products-grid {
        gap: 10px;
    }

    .mobile-product-card-wrapper {
        flex: 0 0 145px;
    }
}

/* RTL Support for Mobile */
[dir="rtl"] .mobile-hero-content,
[dir="rtl"] .mobile-section-header,
[dir="rtl"] .mobile-promo-content {
    text-align: right;
}

[dir="rtl"] .mobile-see-all i,
[dir="rtl"] .mobile-promo-cta i {
    transform: scaleX(-1);
}

[dir="rtl"] .mobile-features-scroll,
[dir="rtl"] .mobile-products-scroll,
[dir="rtl"] .mobile-categories-more {
    direction: rtl;
}
</style>
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
    // Wishlist handlers
    document.querySelectorAll('.wishlist-btn').forEach(button => {
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

    // Promotional Banner Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll('.promo-slide');
    const totalSlides = slides.length;
    let autoPlayInterval;

    function showSlide(index) {
        // Remove active class from all slides
        slides.forEach(slide => slide.classList.remove('active'));

        // Add active class to current slide
        if (slides[index]) {
            slides[index].classList.add('active');
        }
    }

    function changeSlide(direction) {
        currentSlide += direction;

        // Loop back to start/end
        if (currentSlide >= totalSlides) {
            currentSlide = 0;
        } else if (currentSlide < 0) {
            currentSlide = totalSlides - 1;
        }

        showSlide(currentSlide);
        resetAutoPlay();
    }

    function autoPlay() {
        autoPlayInterval = setInterval(() => {
            changeSlide(1);
        }, 15000); // Change slide every 15 seconds
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        autoPlay();
    }

    // Make functions globally accessible
    window.changeSlide = changeSlide;

    // Start auto-play if there are multiple slides
    if (totalSlides > 1) {
        autoPlay();
    }

    // Pause auto-play on hover
    const promoSlider = document.querySelector('.promo-slider-wrapper');
    if (promoSlider) {
        promoSlider.addEventListener('mouseenter', () => {
            clearInterval(autoPlayInterval);
        });

        promoSlider.addEventListener('mouseleave', () => {
            autoPlay();
        });
    }

    // Countdown Timer
    function startCountdown() {
        const endTime = new Date();
        endTime.setHours(23, 59, 59, 999); // End of day

        function updateCountdown() {
            const now = new Date();
            const diff = endTime - now;

            if (diff <= 0) {
                endTime.setDate(endTime.getDate() + 1);
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    startCountdown();

    // Products Slider Navigation
    const slider = document.querySelector('.products-slider');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');

    if (slider && prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -300, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: 300, behavior: 'smooth' });
        });
    }

    // =====================================================
    // MOBILE VERSION JAVASCRIPT
    // =====================================================

    // Mobile Hero Slider
    const mobileSlides = document.querySelectorAll('.mobile-hero-slide');
    const mobileDots = document.querySelectorAll('.mobile-dot');
    let mobileCurrentSlide = 0;
    let mobileAutoPlayInterval;
    const mobileTotalSlides = mobileSlides.length;

    function showMobileSlide(index) {
        mobileSlides.forEach(slide => slide.classList.remove('active'));
        mobileDots.forEach(dot => dot.classList.remove('active'));

        if (mobileSlides[index]) {
            mobileSlides[index].classList.add('active');
        }
        if (mobileDots[index]) {
            mobileDots[index].classList.add('active');
        }
    }

    function nextMobileSlide() {
        mobileCurrentSlide++;
        if (mobileCurrentSlide >= mobileTotalSlides) {
            mobileCurrentSlide = 0;
        }
        showMobileSlide(mobileCurrentSlide);
    }

    function mobileAutoPlay() {
        mobileAutoPlayInterval = setInterval(nextMobileSlide, 5000);
    }

    function resetMobileAutoPlay() {
        clearInterval(mobileAutoPlayInterval);
        mobileAutoPlay();
    }

    // Add click handlers to dots
    mobileDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            mobileCurrentSlide = index;
            showMobileSlide(mobileCurrentSlide);
            resetMobileAutoPlay();
        });
    });

    // Touch swipe support for mobile slider
    const mobileHeroSlider = document.getElementById('mobileHeroSlider');
    if (mobileHeroSlider) {
        let touchStartX = 0;
        let touchEndX = 0;

        mobileHeroSlider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        mobileHeroSlider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    mobileCurrentSlide++;
                    if (mobileCurrentSlide >= mobileTotalSlides) {
                        mobileCurrentSlide = 0;
                    }
                } else {
                    // Swipe right - previous slide
                    mobileCurrentSlide--;
                    if (mobileCurrentSlide < 0) {
                        mobileCurrentSlide = mobileTotalSlides - 1;
                    }
                }
                showMobileSlide(mobileCurrentSlide);
                resetMobileAutoPlay();
            }
        }
    }

    // Start mobile auto-play if there are multiple slides
    if (mobileTotalSlides > 1) {
        mobileAutoPlay();
    }

    // Mobile Countdown Timer
    function startMobileCountdown() {
        const endTime = new Date();
        endTime.setHours(23, 59, 59, 999);

        function updateMobileCountdown() {
            const now = new Date();
            const diff = endTime - now;

            if (diff <= 0) {
                endTime.setDate(endTime.getDate() + 1);
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const mobileHoursEl = document.getElementById('mobileHours');
            const mobileMinutesEl = document.getElementById('mobileMinutes');
            const mobileSecondsEl = document.getElementById('mobileSeconds');

            if (mobileHoursEl) mobileHoursEl.textContent = String(hours).padStart(2, '0');
            if (mobileMinutesEl) mobileMinutesEl.textContent = String(minutes).padStart(2, '0');
            if (mobileSecondsEl) mobileSecondsEl.textContent = String(seconds).padStart(2, '0');
        }

        updateMobileCountdown();
        setInterval(updateMobileCountdown, 1000);
    }

    startMobileCountdown();

    // Mobile horizontal scroll snap behavior enhancement
    const mobileScrollContainers = document.querySelectorAll('.mobile-products-scroll');
    mobileScrollContainers.forEach(container => {
        let isDown = false;
        let startX;
        let scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });

        container.addEventListener('mouseleave', () => {
            isDown = false;
        });

        container.addEventListener('mouseup', () => {
            isDown = false;
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
    });
});
</script>
@endsection
