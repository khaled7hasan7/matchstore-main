@extends('themes.xylo.layouts.master')

@section('title', __('store.orders.order_details'))

@section('css')
<style>
    /* Order Detail Page Modern Design */
    .order-detail-page {
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
        min-height: 100vh;
        padding: 40px 0 60px;
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        background: transparent;
        padding: 20px 0;
        margin-bottom: 20px;
    }

    .breadcrumb-modern ol {
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
        color: #64748b;
        font-size: 14px;
    }

    .breadcrumb-modern li a {
        color: var(--main-color);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .breadcrumb-modern li a:hover {
        color: var(--main-color-light);
    }

    .breadcrumb-modern li.active {
        color: #1e293b;
        font-weight: 600;
    }

    .breadcrumb-separator {
        color: #cbd5e1;
    }

    /* Order Header */
    .order-detail-header {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
    }

    .order-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 2px solid #f1f5f9;
    }

    .order-title-group h1 {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .order-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: #64748b;
        font-size: 14px;
    }

    .order-meta i {
        color: var(--main-color);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #ffffff;
    }

    .status-processing {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
    }

    .status-completed {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
    }

    .status-cancelled, .status-canceled {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
    }

    .order-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .summary-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .summary-value {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }

    .summary-total {
        font-size: 24px;
        font-weight: 700;
        color: var(--main-color);
    }

    /* Order Content Grid */
    .order-content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    /* Order Items */
    .order-items-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--main-color);
    }

    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-item {
        display: flex;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        border-color: var(--main-color);
        background: #ffffff;
    }

    .item-image {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: #ffffff;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .item-name {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .item-attributes {
        font-size: 13px;
        color: #64748b;
    }

    .item-quantity {
        font-size: 14px;
        color: #64748b;
    }

    .item-price-group {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    .item-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--main-color);
    }

    .item-unit-price {
        font-size: 13px;
        color: #94a3b8;
    }

    /* Sidebar Sections */
    .sidebar-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .info-value {
        font-size: 14px;
        color: #1e293b;
        line-height: 1.5;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        color: var(--main-color);
        border: 2px solid var(--main-color);
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: var(--main-color);
        color: #ffffff;
        transform: translateX(-4px);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .order-content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .order-title-group h1 {
            font-size: 24px;
        }

        .order-header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-summary-grid {
            grid-template-columns: 1fr;
        }

        .order-item {
            flex-direction: column;
        }

        .item-image {
            width: 100%;
            height: 200px;
        }

        .item-price-group {
            align-items: flex-start;
        }
    }

    /* RTL Support */
    [dir="rtl"] .btn-back i,
    html[dir="rtl"] .btn-back i {
        transform: scaleX(-1);
    }

    [dir="rtl"] .btn-back:hover,
    html[dir="rtl"] .btn-back:hover {
        transform: translateX(4px);
    }

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
       Mobile Order Detail Styles
       ================================ */

    /* Mobile Order Header */
    .mobile-order-header {
        background: linear-gradient(135deg, {{ config('store.primary_color', '#0e0e0e') }}, #333);
        padding: 16px;
        color: white;
    }

    .mobile-order-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .mobile-order-header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .mobile-order-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .mobile-order-date {
        font-size: 12px;
        opacity: 0.85;
    }

    .mobile-order-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .mobile-status-pending {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #ffffff;
    }

    .mobile-status-processing {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
    }

    .mobile-status-completed {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
    }

    .mobile-status-cancelled, .mobile-status-canceled {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
    }

    /* Mobile Order Content */
    .mobile-order-content {
        padding: 16px;
        padding-bottom: 80px;
        background: #f8f9fa;
    }

    /* Mobile Summary Cards */
    .mobile-order-summary {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }

    .mobile-summary-card {
        background: white;
        border-radius: 12px;
        padding: 14px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .mobile-summary-card.full {
        grid-column: span 2;
    }

    .mobile-summary-label {
        font-size: 11px;
        color: #6c757d;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .mobile-summary-value {
        font-size: 15px;
        font-weight: 600;
        color: #212529;
    }

    .mobile-summary-value.total {
        font-size: 20px;
        font-weight: 700;
        color: var(--main-color);
    }

    /* Mobile Section Card */
    .mobile-section-card {
        background: white;
        border-radius: 14px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .mobile-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border-bottom: 1px solid #eee;
        font-size: 15px;
        font-weight: 600;
        color: #212529;
    }

    .mobile-section-header i {
        color: var(--main-color);
        font-size: 14px;
    }

    .mobile-section-body {
        padding: 16px;
    }

    /* Mobile Order Item */
    .mobile-order-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .mobile-order-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .mobile-order-item:first-child {
        padding-top: 0;
    }

    .mobile-item-image {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f5f5f5;
    }

    .mobile-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mobile-item-info {
        flex: 1;
        min-width: 0;
    }

    .mobile-item-name {
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .mobile-item-attributes {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .mobile-item-qty {
        font-size: 12px;
        color: #6c757d;
    }

    .mobile-item-price {
        font-size: 15px;
        font-weight: 700;
        color: var(--main-color);
        text-align: right;
    }

    .mobile-item-unit-price {
        font-size: 11px;
        color: #6c757d;
        text-align: right;
    }

    /* Mobile Info Row */
    .mobile-info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .mobile-info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .mobile-info-row:first-child {
        padding-top: 0;
    }

    .mobile-info-label {
        font-size: 13px;
        color: #6c757d;
    }

    .mobile-info-value {
        font-size: 13px;
        color: #212529;
        text-align: right;
        max-width: 60%;
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .mobile-order-header {
            padding: 14px 12px;
        }

        .mobile-order-title {
            font-size: 18px;
        }

        .mobile-order-status {
            padding: 5px 10px;
            font-size: 11px;
        }

        .mobile-order-content {
            padding: 12px;
            padding-bottom: 70px;
        }

        .mobile-order-summary {
            gap: 8px;
        }

        .mobile-summary-card {
            padding: 12px 10px;
        }

        .mobile-summary-value.total {
            font-size: 18px;
        }

        .mobile-section-card {
            border-radius: 12px;
        }

        .mobile-item-image {
            width: 60px;
            height: 60px;
        }

        .mobile-item-name {
            font-size: 13px;
        }

        .mobile-item-price {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="order-detail-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb-modern">
            <ol>
                <li><a href="{{ route('xylo.home') }}"><i class="fas fa-home"></i> {{ __('store.common.home') }}</a></li>
                <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                <li><a href="{{ route('customer.orders.index') }}">{{ __('store.orders.title') }}</a></li>
                <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                <li class="active">{{ __('store.orders.order') }} #{{ $order->id }}</li>
            </ol>
        </nav>

        {{-- Back Button --}}
        <a href="{{ route('customer.orders.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            {{ __('store.orders.back_to_orders') }}
        </a>

        {{-- Order Header --}}
        <div class="order-detail-header">
            <div class="order-header-top">
                <div class="order-title-group">
                    <h1>{{ __('store.orders.order') }} #{{ $order->id }}</h1>
                    <div class="order-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('F d, Y') }}</span>
                        <span><i class="far fa-clock"></i> {{ $order->created_at->format('h:i A') }}</span>
                    </div>
                </div>
                <div>
                    @php
                        $statusClass = 'status-' . strtolower($order->status);
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <div class="order-summary-grid">
                <div class="summary-item">
                    <span class="summary-label">{{ __('store.orders.total_amount') }}</span>
                    <span class="summary-total">{{ currency_symbol() }}{{ number_format(convert_price($order->total), 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('store.orders.payment_method') }}</span>
                    <span class="summary-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('store.orders.payment_status') }}</span>
                    <span class="summary-value">{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">{{ __('store.orders.items_count') }}</span>
                    <span class="summary-value">{{ $order->details->count() }} {{ __('store.orders.items') }}</span>
                </div>
            </div>
        </div>

        {{-- Order Content --}}
        <div class="order-content-grid">
            {{-- Order Items --}}
            <div class="order-items-section">
                <h2 class="section-title">
                    <i class="fas fa-box"></i>
                    {{ __('store.orders.order_items') }}
                </h2>

                <div class="order-items-list">
                    @foreach($order->details as $detail)
                        <div class="order-item">
                            <div class="item-image">
                                @php
                                    $finalImageUrl = store_image(optional($detail->product->thumbnail)->image_url ?? 'default-thumbnail.jpg');
                                @endphp
                                <img src="{{ $finalImageUrl }}"
                                     alt="{{ optional($detail->product->translation)->name ?? 'Product' }}"
                                     onerror="this.src='https://via.placeholder.com/100x100?text=No+Image'">
                            </div>

                            <div class="item-details">
                                <h3 class="item-name">{{ optional($detail->product->translation)->name ?? __('store.common.no_name') }}</h3>
                                @if($detail->attributes)
                                    <p class="item-attributes">
                                        @php
                                            $attributes = is_string($detail->attributes) ? json_decode($detail->attributes, true) : $detail->attributes;
                                        @endphp
                                        @if(is_array($attributes))
                                            @foreach($attributes as $key => $value)
                                                <span>{{ ucfirst($key) }}: {{ $value }}</span>
                                                @if(!$loop->last) | @endif
                                            @endforeach
                                        @endif
                                    </p>
                                @endif
                                <p class="item-quantity">{{ __('store.orders.quantity') }}: {{ $detail->quantity }}</p>
                            </div>

                            <div class="item-price-group">
                                <div class="item-price">{{ currency_symbol() }}{{ number_format(convert_price($detail->price * $detail->quantity), 2) }}</div>
                                <div class="item-unit-price">{{ currency_symbol() }}{{ number_format(convert_price($detail->price), 2) }} {{ __('store.orders.each') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                {{-- Shipping Address --}}
                <div class="sidebar-section">
                    <h3 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ __('store.orders.shipping_address') }}
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">{{ __('store.orders.name') }}</span>
                            <span class="info-value">{{ $order->first_name }} {{ $order->last_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">{{ __('store.orders.address') }}</span>
                            <span class="info-value">
                                {{ $order->address }}
                                @if($order->suite), {{ $order->suite }}@endif
                                <br>{{ $order->city }}, {{ $order->country }}
                                @if($order->zipcode)<br>{{ $order->zipcode }}@endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="sidebar-section">
                    <h3 class="section-title">
                        <i class="fas fa-address-book"></i>
                        {{ __('store.orders.contact_info') }}
                    </h3>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">{{ __('store.orders.email') }}</span>
                            <span class="info-value">{{ $order->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">{{ __('store.orders.phone') }}</span>
                            <span class="info-value">{{ $order->phone }}</span>
                        </div>
                    </div>
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
<div class="mobile-only">

    {{-- Mobile Order Header --}}
    <div class="mobile-order-header">
        <a href="{{ route('customer.orders.index') }}" class="mobile-order-back">
            <i class="fas fa-arrow-left"></i>
            {{ __('store.orders.back_to_orders') }}
        </a>
        <div class="mobile-order-header-content">
            <div>
                <div class="mobile-order-title">{{ __('store.orders.order') }} #{{ $order->id }}</div>
                <div class="mobile-order-date">
                    <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}
                </div>
            </div>
            @php
                $mobileStatusClass = 'mobile-status-' . strtolower($order->status);
            @endphp
            <span class="mobile-order-status {{ $mobileStatusClass }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    {{-- Mobile Order Content --}}
    <div class="mobile-order-content">

        {{-- Mobile Summary Cards --}}
        <div class="mobile-order-summary">
            <div class="mobile-summary-card full">
                <div class="mobile-summary-label">{{ __('store.orders.total_amount') }}</div>
                <div class="mobile-summary-value total">{{ currency_symbol() }}{{ number_format(convert_price($order->total), 2) }}</div>
            </div>
            <div class="mobile-summary-card">
                <div class="mobile-summary-label">{{ __('store.orders.payment_method') }}</div>
                <div class="mobile-summary-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
            </div>
            <div class="mobile-summary-card">
                <div class="mobile-summary-label">{{ __('store.orders.payment_status') }}</div>
                <div class="mobile-summary-value">{{ ucfirst($order->payment_status) }}</div>
            </div>
        </div>

        {{-- Mobile Order Items --}}
        <div class="mobile-section-card">
            <div class="mobile-section-header">
                <i class="fas fa-box"></i>
                {{ __('store.orders.order_items') }} ({{ $order->details->count() }})
            </div>
            <div class="mobile-section-body">
                @foreach($order->details as $detail)
                    <div class="mobile-order-item">
                        <div class="mobile-item-image">
                            @php
                                $finalImageUrl = store_image(optional($detail->product->thumbnail)->image_url ?? 'default-thumbnail.jpg');
                            @endphp
                            <img src="{{ $finalImageUrl }}"
                                 alt="{{ optional($detail->product->translation)->name ?? 'Product' }}"
                                 onerror="this.src='https://via.placeholder.com/70x70?text=No+Image'">
                        </div>
                        <div class="mobile-item-info">
                            <div class="mobile-item-name">{{ optional($detail->product->translation)->name ?? __('store.common.no_name') }}</div>
                            @if($detail->attributes)
                                <div class="mobile-item-attributes">
                                    @php
                                        $attributes = is_string($detail->attributes) ? json_decode($detail->attributes, true) : $detail->attributes;
                                    @endphp
                                    @if(is_array($attributes))
                                        @foreach($attributes as $key => $value)
                                            {{ ucfirst($key) }}: {{ $value }}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            <div class="mobile-item-qty">{{ __('store.orders.quantity') }}: {{ $detail->quantity }}</div>
                        </div>
                        <div>
                            <div class="mobile-item-price">{{ currency_symbol() }}{{ number_format(convert_price($detail->price * $detail->quantity), 2) }}</div>
                            <div class="mobile-item-unit-price">{{ currency_symbol() }}{{ number_format(convert_price($detail->price), 2) }} {{ __('store.orders.each') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Mobile Shipping Address --}}
        <div class="mobile-section-card">
            <div class="mobile-section-header">
                <i class="fas fa-map-marker-alt"></i>
                {{ __('store.orders.shipping_address') }}
            </div>
            <div class="mobile-section-body">
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.name') }}</span>
                    <span class="mobile-info-value">{{ $order->first_name }} {{ $order->last_name }}</span>
                </div>
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.address') }}</span>
                    <span class="mobile-info-value">
                        {{ $order->address }}@if($order->suite), {{ $order->suite }}@endif
                    </span>
                </div>
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.city') ?? 'City' }}</span>
                    <span class="mobile-info-value">{{ $order->city }}, {{ $order->country }}</span>
                </div>
                @if($order->zipcode)
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.zipcode') ?? 'Zip Code' }}</span>
                    <span class="mobile-info-value">{{ $order->zipcode }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Mobile Contact Information --}}
        <div class="mobile-section-card">
            <div class="mobile-section-header">
                <i class="fas fa-address-book"></i>
                {{ __('store.orders.contact_info') }}
            </div>
            <div class="mobile-section-body">
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.email') }}</span>
                    <span class="mobile-info-value">{{ $order->email }}</span>
                </div>
                <div class="mobile-info-row">
                    <span class="mobile-info-label">{{ __('store.orders.phone') }}</span>
                    <span class="mobile-info-value">{{ $order->phone }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
{{-- END MOBILE VERSION --}}

@endsection
