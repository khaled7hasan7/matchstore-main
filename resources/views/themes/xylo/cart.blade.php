@extends('themes.xylo.layouts.master')

@section('content')
    @php $currency = activeCurrency(); @endphp
    @php $total = 0; @endphp

    {{-- ================================
        DESKTOP VERSION
        ================================ --}}
    <div class="desktop-only">
    <section class="breadcrumb-section">
        <div class="container">
            <div class="breadcrumbs" aria-label="breadcrumb">
                <a href="{{ url('/') }}">{{ __('store.cart.breadcrumb_home') }}</a>
                <i class="fa fa-angle-right"></i>
                <span>{{ __('store.cart.breadcrumb_cart') }}</span>
            </div>
        </div>
    </section>
    <div class="cart-page pb-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if(empty($cart))
                    <p class="alert alert-warning">{{ __('store.cart.empty_cart') }}</p>
                @else
                <div class="table-responsive">
                    <table class="w-100 table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('store.cart.product') }}</th>
                                <th>{{ __('store.cart.price') }}</th>
                                <th>{{ __('store.cart.quantity') }}</th>
                                <th>{{ __('store.cart.subtotal') }}</th>
                            </tr>
                        </thead>
                        
                      
                        <tbody>
    @foreach ($cart as $key => $item)
        @php
            $product = \App\Models\Product::with(['translations', 'thumbnail'])->find($item['product_id']);
            $variant = isset($item['variant_id'])
                        ? \App\Models\ProductVariant::with('images')->find($item['variant_id'])
                        : \App\Models\ProductVariant::where('product_id', $item['product_id'])->where('is_primary', true)->first();

            $subtotal = $item['price'] * $item['quantity'];
        @endphp
        <tr>
            <td>
                <button class="btn btn-link p-0 bnlink remove-from-cart" data-id="{{ $key }}">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </td>
            <td>
                <div class="pr-imghead">
                    @php
                        $imageUrl = null;

                        // Try to get variant image first
                        if ($variant && $variant->images && $variant->images->first()) {
                            $imageUrl = $variant->images->first()->image_url;
                        }
                        // Fallback to product thumbnail
                        elseif ($product->thumbnail) {
                            $imageUrl = $product->thumbnail->image_url;
                        }

                        // Handle image URL
                        if ($imageUrl) {
                            if (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                $finalImageUrl = $imageUrl;
                            } else {
                                $finalImageUrl = asset('storage/' . $imageUrl);
                            }
                        } else {
                            $finalImageUrl = asset('images/default-product.png');
                        }
                    @endphp
                    <img src="{{ $finalImageUrl }}"
                         alt="{{ $variant->name ?? $product->translation->name }}"
                         onerror="this.src='{{ asset('images/default-product.png') }}'">
                    <p>{{ $variant->name ?? $product->translation->name }}</p>
                </div>
                
                <div id="size-color-wrapper">
                    @php
                        $sizes = [];
                        $colors = [];
                    @endphp

                    @if (!empty($item['attributes']))
                        @foreach ($item['attributes'] as $attributeValueId)
                            @php
                                $attributeValue = \App\Models\AttributeValue::with('attribute')->find($attributeValueId);
                            @endphp
                            @if ($attributeValue && $attributeValue->attribute)
                                @php
                                    $attributeName = strtolower($attributeValue->attribute->name);
                                    if ($attributeName === 'size') {
                                        $sizes[] = $attributeValue->translated_value;
                                    } elseif ($attributeName === 'color') {
                                        $colors[] = $attributeValue->translated_value;
                                    }
                                @endphp
                            @endif
                        @endforeach
                    @endif

                    @if (!empty($sizes))
                        <span id="product-size">
                            @foreach ($sizes as $size)
                                <span class="size-box">{{ $size }}</span>
                            @endforeach
                        </span>
                    @endif

                    @if (!empty($colors))
                        <span id="product-color">
                            @foreach ($colors as $color)
                                <span class="color-circle {{ strtolower($color) }}" ></span>
                            @endforeach
                        </span>
                    @endif
                </div>
            </td>
            <td>
                <strong>{{ $currency->symbol }}{{ number_format($item['price'], 2) }}</strong>
            </td>
            <td>
                <div class="quantity-selector">
                    <button type="button" class="qty-btn qty-minus" data-key="{{ $key }}" data-stock="{{ $variant->stock ?? 0 }}">
                        <i class="fa fa-minus"></i>
                    </button>
                    <input type="number" value="{{ $item['quantity'] }}" min="1" max="{{ $variant->stock ?? 0 }}" class="qty-input" data-key="{{ $key }}" readonly>
                    <button type="button" class="qty-btn qty-plus" data-key="{{ $key }}" data-stock="{{ $variant->stock ?? 0 }}">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="loading-spinner" id="loading-{{ $key }}" style="display:none;">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </td>
            <td>
                <strong class="subtotal-{{ $key }}">{{ $currency->symbol }}{{ number_format($subtotal, 2) }}</strong>
            </td>
        </tr>
        @php $total += $subtotal; @endphp
    @endforeach
</tbody>


                    </table>
                </div>
                @endif
                <div class="btn-group mt-4">
                    <a href="{{ route('xylo.home') }}" class="btn-light">{{ __('store.cart.continue_shopping') }}</a>
                    <a href="#" class="read-more update-cart">{{ __('store.cart.update_cart') }}</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="cart-box">
                    <h3 class="cart-heading">{{ __('store.cart.cart_totals') }}</h3>

                    <div class="row border-bottom pb-2 mb-2 mt-4">
                        <div class="col-6 col-md-4">{{ __('store.cart.subtotal_label') }}</div>
                        <div class="col-6 col-md-8 text-end">{{ $currency->symbol }}{{ number_format($total, 2) }}</div>
                    </div>

                    @php
                        $coupon = session('cart_coupon');
                        $discountAmount = 0;
                        if ($coupon) {
                            if ($coupon['type'] === 'percentage') {
                                $discountAmount = $total * ($coupon['discount'] / 100);
                            } else {
                                $discountAmount = $coupon['discount'];
                            }
                        }
                        $finalTotal = max(0, $total - $discountAmount);
                    @endphp

                    @if($coupon)
                        <div class="row border-bottom pb-2 mb-2 d-flex align-items-center">
                            <div class="col-8 d-flex align-items-center">Discount ({{ $coupon['code'] }})</div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                    -{{ $currency->symbol }}{{ number_format($discountAmount, 2) }}
                                <form id="removeCouponForm" class="ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm p-1 remove-coupon"
                                        style="border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;">
                                        x
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <div class="row border-bottom pb-2 mb-2">
                        <div class="col-6 col-md-4">{{ __('store.cart.total_label') }}</div>
                        <div class="col-6 col-md-8 text-end"><span>{{ $currency->symbol }}{{ number_format($finalTotal, 2) }}</span></div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('checkout.index') }}" class="proceed-to-checkout d-block text-center">{{ __('store.cart.proceed_to_checkout') }}</a>
                    </div>
                </div>

                <div class="coupon-box mt-4">
                    <h3 class="cart-heading mb-4">{{ __('store.cart.coupon_heading') }}</h3>

                    <form id="applyCouponForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="code" id="coupon_code" placeholder="{{ __('store.cart.coupon_placeholder') }}" class="form-control">
                        </div>
                        <button type="submit" class="btn-light d-block text-center w-100">{{ __('store.cart.apply_coupon') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
    </div>
    {{-- END DESKTOP VERSION --}}

    {{-- ================================
        MOBILE VERSION
        ================================ --}}
    <div class="mobile-only mobile-cart-page">

        {{-- Mobile Cart Header --}}
        <div class="mobile-cart-header">
            <h1>{{ __('store.cart.breadcrumb_cart') }}</h1>
            <span class="mobile-cart-count">{{ count($cart ?? []) }} {{ count($cart ?? []) == 1 ? 'item' : 'items' }}</span>
        </div>

        @if(empty($cart))
            {{-- Mobile Empty Cart --}}
            <div class="mobile-empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>{{ __('store.cart.empty_cart') ?? 'Your cart is empty' }}</h2>
                <p>{{ __('store.cart.empty_cart_message') ?? 'Looks like you haven\'t added anything to your cart yet.' }}</p>
                <a href="{{ route('xylo.home') }}">{{ __('store.cart.continue_shopping') }}</a>
            </div>
        @else
            {{-- Mobile Cart Items --}}
            <div class="mobile-cart-items">
                @php $mobileTotal = 0; @endphp
                @foreach ($cart as $key => $item)
                    @php
                        $product = \App\Models\Product::with(['translations', 'thumbnail'])->find($item['product_id']);
                        $variant = isset($item['variant_id'])
                                    ? \App\Models\ProductVariant::with('images')->find($item['variant_id'])
                                    : \App\Models\ProductVariant::where('product_id', $item['product_id'])->where('is_primary', true)->first();

                        $subtotal = $item['price'] * $item['quantity'];
                        $mobileTotal += $subtotal;

                        // Get image URL
                        $imageUrl = null;
                        if ($variant && $variant->images && $variant->images->first()) {
                            $imageUrl = $variant->images->first()->image_url;
                        } elseif ($product->thumbnail) {
                            $imageUrl = $product->thumbnail->image_url;
                        }

                        if ($imageUrl) {
                            $finalImageUrl = \Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])
                                ? $imageUrl
                                : asset('storage/' . $imageUrl);
                        } else {
                            $finalImageUrl = asset('images/default-product.png');
                        }

                        // Get sizes and colors
                        $sizes = [];
                        $colors = [];
                        if (!empty($item['attributes'])) {
                            foreach ($item['attributes'] as $attributeValueId) {
                                $attributeValue = \App\Models\AttributeValue::with('attribute')->find($attributeValueId);
                                if ($attributeValue && $attributeValue->attribute) {
                                    $attributeName = strtolower($attributeValue->attribute->name);
                                    if ($attributeName === 'size') {
                                        $sizes[] = $attributeValue->translated_value;
                                    } elseif ($attributeName === 'color') {
                                        $colors[] = $attributeValue->translated_value;
                                    }
                                }
                            }
                        }
                    @endphp

                    <div class="mobile-cart-item" data-key="{{ $key }}">
                        <div class="mobile-cart-item-header">
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ $variant->name ?? $product->translation->name }}"
                                 class="mobile-cart-item-image"
                                 onerror="this.src='{{ asset('images/default-product.png') }}'">

                            <div class="mobile-cart-item-info">
                                <h3 class="mobile-cart-item-name">{{ $variant->name ?? $product->translation->name }}</h3>

                                @if (!empty($sizes) || !empty($colors))
                                    <div class="mobile-cart-item-variants">
                                        @foreach ($sizes as $size)
                                            <span class="mobile-variant-tag">{{ $size }}</span>
                                        @endforeach
                                        @foreach ($colors as $color)
                                            <span class="mobile-variant-tag">{{ $color }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mobile-cart-item-price">{{ $currency->symbol }}{{ number_format($item['price'], 2) }}</div>
                            </div>

                            <button class="mobile-cart-item-remove mobile-remove-from-cart" data-id="{{ $key }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <div class="mobile-cart-item-footer">
                            <div class="mobile-qty-selector">
                                <button type="button" class="mobile-qty-btn mobile-qty-minus" data-key="{{ $key }}" data-stock="{{ $variant->stock ?? 0 }}">−</button>
                                <input type="number" value="{{ $item['quantity'] }}" min="1" max="{{ $variant->stock ?? 0 }}" class="mobile-qty-input" data-key="{{ $key }}" readonly>
                                <button type="button" class="mobile-qty-btn mobile-qty-plus" data-key="{{ $key }}" data-stock="{{ $variant->stock ?? 0 }}">+</button>
                            </div>

                            <div class="mobile-cart-subtotal">
                                <span class="mobile-cart-subtotal-label">{{ __('store.cart.subtotal') }}</span>
                                <span class="mobile-cart-subtotal-value mobile-subtotal-{{ $key }}">{{ $currency->symbol }}{{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Mobile Coupon Section --}}
            <div class="mobile-coupon-section {{ session('cart_coupon') ? 'open' : '' }}">
                <div class="mobile-coupon-header" onclick="this.parentElement.classList.toggle('open')">
                    <h3><i class="fas fa-tag"></i> {{ __('store.cart.coupon_heading') }}</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="mobile-coupon-content">
                    @php
                        $coupon = session('cart_coupon');
                        $discountAmount = 0;
                        if ($coupon) {
                            if ($coupon['type'] === 'percentage') {
                                $discountAmount = $mobileTotal * ($coupon['discount'] / 100);
                            } else {
                                $discountAmount = $coupon['discount'];
                            }
                        }
                        $finalTotal = max(0, $mobileTotal - $discountAmount);
                    @endphp

                    @if($coupon)
                        <div class="mobile-applied-coupon">
                            <span><i class="fas fa-check-circle"></i> {{ $coupon['code'] }} applied: -{{ $currency->symbol }}{{ number_format($discountAmount, 2) }}</span>
                            <button type="button" class="mobile-remove-coupon" id="mobileRemoveCoupon">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @else
                        <form class="mobile-coupon-form" id="mobileCouponForm">
                            @csrf
                            <input type="text" name="code" placeholder="{{ __('store.cart.coupon_placeholder') }}" class="mobile-coupon-input" id="mobileCouponCode">
                            <button type="submit" class="mobile-coupon-btn">{{ __('store.cart.apply_coupon') ?? 'Apply' }}</button>
                        </form>
                    @endif
                </div>
            </div>
        @endif

    </div>
    {{-- END MOBILE VERSION --}}

    {{-- Mobile Cart Summary - Sticky Bottom --}}
    @if(!empty($cart))
    <div class="mobile-cart-summary">
        <div class="mobile-summary-inner">
            <div class="mobile-summary-row">
                <span>{{ __('store.cart.subtotal_label') }}</span>
                <span>{{ $currency->symbol }}{{ number_format($mobileTotal ?? $total, 2) }}</span>
            </div>

            @if(session('cart_coupon'))
                <div class="mobile-summary-row discount">
                    <span>{{ __('store.cart.discount') ?? 'Discount' }} ({{ session('cart_coupon')['code'] }})</span>
                    <span>-{{ $currency->symbol }}{{ number_format($discountAmount ?? 0, 2) }}</span>
                </div>
            @endif

            <div class="mobile-summary-total">
                <span>{{ __('store.cart.total_label') }}</span>
                <span>{{ $currency->symbol }}{{ number_format($finalTotal ?? $mobileTotal ?? $total, 2) }}</span>
            </div>

            <a href="{{ route('checkout.index') }}" class="mobile-checkout-btn">
                <i class="fas fa-lock"></i>
                {{ __('store.cart.proceed_to_checkout') }}
            </a>
        </div>
    </div>
    @endif

@endsection

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

    /* Quantity Selector Styles */
    .quantity-selector {
        display: inline-flex;
        align-items: center;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        overflow: hidden;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border: none;
        background-color: {{ config('store.secondary_color', '#f8f9fa') }};
        color: {{ config('store.primary_color', '#0e0e0e') }};
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .qty-btn:hover:not(:disabled) {
        background-color: {{ config('store.accent_color', '#ffc107') }};
        color: {{ config('store.dark_color', '#212529') }};
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .qty-input {
        width: 50px;
        text-align: center;
        border: none;
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        height: 32px;
        font-size: 0.9rem;
        font-weight: 600;
        background-color: #ffffff;
    }

    .qty-input:focus {
        outline: none;
    }

    .loading-spinner {
        margin-top: 0.5rem;
        color: {{ config('store.accent_color', '#ffc107') }};
        font-size: 0.9rem;
    }

    /* RTL Support */
    [dir="rtl"] .quantity-selector {
        direction: ltr; /* Keep LTR order for better UX */
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .quantity-selector {
            margin: 0.5rem 0;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
        }

        .qty-input {
            width: 45px;
            height: 28px;
        }

        .cart-page {
            padding-top: 1.5rem !important;
            padding-bottom: 2rem !important;
        }

        .breadcrumb-section {
            padding: 0.75rem 0;
        }

        .breadcrumbs {
            font-size: 0.85rem;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: flex;
            flex-wrap: wrap;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #fff;
        }

        .table tbody td {
            border: none;
            padding: 0.5rem;
        }

        .table tbody td:first-child {
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        .table tbody td:nth-child(2) {
            width: 100%;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eee;
            margin-bottom: 0.75rem;
        }

        .table tbody td:nth-child(3),
        .table tbody td:nth-child(4),
        .table tbody td:nth-child(5) {
            width: 33.33%;
            text-align: center;
        }

        .pr-imghead {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pr-imghead img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }

        .pr-imghead p {
            font-size: 0.9rem;
            margin: 0;
        }

        #size-color-wrapper {
            margin-top: 0.5rem;
        }

        .cart-box,
        .coupon-box {
            border-radius: 10px;
            padding: 1.25rem;
        }

        .cart-heading {
            font-size: 1.1rem;
        }

        .proceed-to-checkout {
            padding: 0.85rem;
            font-size: 0.9rem;
        }

        .btn-group {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-group a {
            width: 100%;
            text-align: center;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .cart-page {
            padding-top: 1rem !important;
            padding-bottom: 1.5rem !important;
        }

        .breadcrumbs {
            font-size: 0.75rem;
        }

        .table tbody tr {
            padding: 0.75rem;
            position: relative;
        }

        .table tbody td:first-child {
            right: 0.75rem;
            top: 0.75rem;
        }

        .pr-imghead {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .pr-imghead img {
            width: 60px;
            height: 60px;
        }

        .pr-imghead p {
            font-size: 0.8rem;
        }

        .table tbody td:nth-child(3),
        .table tbody td:nth-child(4),
        .table tbody td:nth-child(5) {
            font-size: 0.85rem;
        }

        .table tbody td:nth-child(3)::before,
        .table tbody td:nth-child(4)::before,
        .table tbody td:nth-child(5)::before {
            display: block;
            font-size: 0.7rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .table tbody td:nth-child(3)::before {
            content: 'Price';
        }

        .table tbody td:nth-child(4)::before {
            content: 'Qty';
        }

        .table tbody td:nth-child(5)::before {
            content: 'Subtotal';
        }

        .cart-box,
        .coupon-box {
            padding: 1rem;
        }

        .cart-heading {
            font-size: 1rem;
        }

        .proceed-to-checkout {
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        #coupon_code {
            font-size: 0.9rem;
            padding: 0.65rem 0.85rem;
        }

        .remove-coupon {
            width: 22px !important;
            height: 22px !important;
            font-size: 0.7rem !important;
        }
    }

    /* ================================
       Mobile Cart Styles
       ================================ */

    /* Mobile Cart Header */
    .mobile-cart-header {
        background: #fff;
        padding: 16px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-cart-header h1 {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #212529;
    }

    .mobile-cart-count {
        font-size: 13px;
        color: #6c757d;
    }

    /* Mobile Cart Items */
    .mobile-cart-items {
        padding: 12px;
        background: #f8f9fa;
    }

    .mobile-cart-item {
        background: #fff;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .mobile-cart-item-header {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .mobile-cart-item-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .mobile-cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .mobile-cart-item-name {
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 6px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .mobile-cart-item-variants {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 6px;
    }

    .mobile-variant-tag {
        font-size: 11px;
        background: #f0f0f0;
        padding: 3px 8px;
        border-radius: 4px;
        color: #495057;
    }

    .mobile-cart-item-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--main-color);
    }

    .mobile-cart-item-remove {
        width: 32px;
        height: 32px;
        border: none;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #dc3545;
        flex-shrink: 0;
    }

    .mobile-cart-item-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }

    .mobile-qty-selector {
        display: flex;
        align-items: center;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .mobile-qty-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: #f8f9fa;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mobile-qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .mobile-qty-input {
        width: 44px;
        height: 36px;
        border: none;
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
    }

    .mobile-cart-subtotal {
        text-align: right;
    }

    .mobile-cart-subtotal-label {
        font-size: 11px;
        color: #6c757d;
        display: block;
    }

    .mobile-cart-subtotal-value {
        font-size: 16px;
        font-weight: 700;
        color: #212529;
    }

    /* Mobile Empty Cart */
    .mobile-empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
    }

    .mobile-empty-cart i {
        font-size: 60px;
        color: #dee2e6;
        margin-bottom: 16px;
    }

    .mobile-empty-cart h2 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .mobile-empty-cart p {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .mobile-empty-cart a {
        display: inline-block;
        background: var(--main-color);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    /* Mobile Coupon Section */
    .mobile-coupon-section {
        background: #fff;
        padding: 16px;
        margin: 12px;
        border-radius: 12px;
    }

    .mobile-coupon-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .mobile-coupon-header h3 {
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mobile-coupon-header h3 i {
        color: var(--main-color);
    }

    .mobile-coupon-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .mobile-coupon-section.open .mobile-coupon-content {
        max-height: 200px;
    }

    .mobile-coupon-form {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }

    .mobile-coupon-input {
        flex: 1;
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 14px;
    }

    .mobile-coupon-btn {
        background: var(--main-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
    }

    .mobile-applied-coupon {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #d1f4e0;
        padding: 10px 14px;
        border-radius: 8px;
        margin-top: 12px;
    }

    .mobile-applied-coupon span {
        font-size: 13px;
        color: #198754;
        font-weight: 500;
    }

    .mobile-remove-coupon {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-size: 16px;
    }

    /* Mobile Cart Summary - Sticky Bottom */
    .mobile-cart-summary {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        display: none;
    }

    @media (max-width: 768px) {
        .mobile-cart-summary {
            display: block !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }

        /* Ensure footer doesn't interfere on cart page */
        .mobile-cart-page ~ footer,
        .mobile-cart-page + footer {
            margin-bottom: 160px;
        }
    }

    .mobile-summary-inner {
        padding: 14px 16px 16px;
        min-height: 140px;
    }

    .mobile-summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .mobile-summary-row.discount {
        color: #198754;
    }

    .mobile-summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 17px;
        font-weight: 700;
        padding-top: 10px;
        border-top: 1px solid #eee;
        margin-bottom: 14px;
        color: #212529;
    }

    .mobile-checkout-btn {
        width: 100%;
        background: var(--main-color);
        color: white !important;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .mobile-checkout-btn:hover {
        background: #6fa118;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(132, 204, 22, 0.3);
    }

    /* Add padding at bottom for sticky bar */
    .mobile-only.mobile-cart-page {
        padding-bottom: 200px !important;
    }

    @media (max-width: 768px) {
        body {
            padding-bottom: 0 !important;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .mobile-cart-item {
            padding: 12px;
        }

        .mobile-cart-item-image {
            width: 70px;
            height: 70px;
        }

        .mobile-cart-item-name {
            font-size: 13px;
        }

        .mobile-cart-item-price {
            font-size: 14px;
        }

        .mobile-qty-btn {
            width: 32px;
            height: 32px;
        }

        .mobile-qty-input {
            width: 40px;
            height: 32px;
        }
    }
</style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        // Auto-update cart on quantity change
        $('.qty-plus, .qty-minus').on('click', function() {
            const key = $(this).data('key');
            const stock = $(this).data('stock');
            const input = $(`.qty-input[data-key="${key}"]`);
            const currentQty = parseInt(input.val());
            let newQty = currentQty;

            if ($(this).hasClass('qty-plus')) {
                newQty = currentQty + 1;
                if (newQty > stock) {
                    toastr.error("{{ __('store.cart.insufficient_stock') }}", "{{ __('store.cart.error') }}", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000
                    });
                    return;
                }
            } else {
                newQty = currentQty - 1;
                if (newQty < 1) return;
            }

            // Show loading
            $(`#loading-${key}`).show();
            $(this).prop('disabled', true);

            // Build cart data
            let cartData = [];
            $('tbody tr').each(function() {
                const itemKey = $(this).find('.qty-input').data('key');
                const itemQty = itemKey === key ? newQty : parseInt($(this).find('.qty-input').val());

                cartData.push({
                    product_id: itemKey,
                    quantity: itemQty
                });
            });

            // AJAX update
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart: cartData
                },
                success: function(response) {
                    if (response.success) {
                        // Update quantity input
                        input.val(newQty);

                        // Reload page to update totals
                        setTimeout(() => {
                            location.reload();
                        }, 300);

                        // Show success toast
                        toastr.success("{{ __('store.cart.updated') }}", "{{ __('store.profile.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 2000
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error("{{ __('store.cart.error') }}", "{{ __('store.cart.error') }}", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000
                    });
                },
                complete: function() {
                    $(`#loading-${key}`).hide();
                    $(`.qty-btn[data-key="${key}"]`).prop('disabled', false);
                }
            });
        });

        // Manual update cart button (kept for compatibility)
        $('.update-cart').click(function(e) {
            e.preventDefault();
            location.reload();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function() {
                let productId = this.dataset.id;

                fetch("{{ route('cart.remove') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    toastr.success("{{ session('success') }}", data.message, {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    location.reload();
                });
            });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("applyCouponForm")?.addEventListener("submit", function(e) {
        e.preventDefault();
        let code = document.getElementById("coupon_code").value;
        fetch("{{ route('cart.applyCoupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message, "{{ __('store.cart.success') }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(data.message, "{{ __('store.cart.coupon_error') }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            }
        });
    });

    document.getElementById("removeCouponForm")?.addEventListener("submit", function(e) {
        e.preventDefault();
        fetch("{{ route('cart.removeCoupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            toastr.success(data.message, "Removed", {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 5000
            });
            
            setTimeout(() => {
                if (data.success) location.reload();
            }, 1000);

        });
    });
});
</script>

<script>
// ================================
// MOBILE CART FUNCTIONS
// ================================

$(document).ready(function() {
    // Mobile quantity buttons
    $('.mobile-qty-plus, .mobile-qty-minus').on('click', function() {
        const key = $(this).data('key');
        const stock = $(this).data('stock');
        const input = $(`.mobile-qty-input[data-key="${key}"]`);
        const currentQty = parseInt(input.val());
        let newQty = currentQty;

        if ($(this).hasClass('mobile-qty-plus')) {
            newQty = currentQty + 1;
            if (newQty > stock) {
                toastr.error("{{ __('store.cart.insufficient_stock') }}", "{{ __('store.cart.error') }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-center",
                    timeOut: 3000
                });
                return;
            }
        } else {
            newQty = currentQty - 1;
            if (newQty < 1) return;
        }

        // Disable buttons during update
        $(this).prop('disabled', true);

        // Build cart data
        let cartData = [];
        $('.mobile-cart-item').each(function() {
            const itemKey = $(this).data('key');
            const itemQty = itemKey === key ? newQty : parseInt($(this).find('.mobile-qty-input').val());

            cartData.push({
                product_id: itemKey,
                quantity: itemQty
            });
        });

        // AJAX update
        $.ajax({
            url: "{{ route('cart.update') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart: cartData
            },
            success: function(response) {
                if (response.success) {
                    input.val(newQty);
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                    toastr.success("{{ __('store.cart.updated') }}", "", {
                        closeButton: true,
                        positionClass: "toast-top-center",
                        timeOut: 2000
                    });
                }
            },
            error: function(xhr) {
                toastr.error("{{ __('store.cart.error') }}", "", {
                    closeButton: true,
                    positionClass: "toast-top-center",
                    timeOut: 3000
                });
            },
            complete: function() {
                $(`.mobile-qty-btn[data-key="${key}"]`).prop('disabled', false);
            }
        });
    });

    // Mobile remove from cart
    $('.mobile-remove-from-cart').on('click', function() {
        let productId = $(this).data('id');

        fetch("{{ route('cart.remove') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            toastr.success(data.message, "", {
                closeButton: true,
                positionClass: "toast-top-center",
                timeOut: 2000
            });
            location.reload();
        });
    });

    // Mobile coupon form
    $('#mobileCouponForm').on('submit', function(e) {
        e.preventDefault();
        let code = $('#mobileCouponCode').val();

        fetch("{{ route('cart.applyCoupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message, "", {
                    closeButton: true,
                    positionClass: "toast-top-center",
                    timeOut: 2000
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(data.message, "", {
                    closeButton: true,
                    positionClass: "toast-top-center",
                    timeOut: 3000
                });
            }
        });
    });

    // Mobile remove coupon
    $('#mobileRemoveCoupon').on('click', function() {
        fetch("{{ route('cart.removeCoupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            toastr.success(data.message, "", {
                closeButton: true,
                positionClass: "toast-top-center",
                timeOut: 2000
            });
            setTimeout(() => {
                if (data.success) location.reload();
            }, 1000);
        });
    });
});
</script>

@endsection