@extends('themes.xylo.layouts.master')

@section('title', __('store.orders.title'))

@section('css')
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

    /* Orders Page Modern Design */
    .orders-page {
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
        min-height: 100vh;
        padding: 40px 0 60px;
    }

    /* Page Header */
    .page-header-modern {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 60px 0;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .page-header-modern::before {
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

    .page-header-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
        text-align: center;
    }

    .page-icon {
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

    .page-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 12px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .page-subtitle {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Orders List */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(132, 204, 22, 0.15);
        border-color: var(--main-color);
    }

    .order-card-header {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 20px 24px;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .order-number {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-number i {
        color: var(--main-color);
    }

    .order-date {
        font-size: 14px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-card-body {
        padding: 24px;
    }

    .order-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .order-info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .order-info-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .order-info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    .order-total {
        font-size: 20px;
        font-weight: 700;
        color: var(--main-color);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
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

    .status-cancelled {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
    }

    /* Order Actions */
    .order-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f1f5f9;
    }

    .btn-view-order {
        flex: 1;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        border: none;
        padding: 12px 24px;
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

    .btn-view-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(132, 204, 22, 0.4);
        color: #ffffff;
    }

    .btn-reorder {
        background: #f8fafc;
        color: var(--main-color);
        border: 2px solid var(--main-color);
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reorder:hover {
        background: var(--main-color);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-orders {
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

    .btn-start-shopping {
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

    .btn-start-shopping:hover {
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
    @media (max-width: 768px) {
        .orders-page {
            padding: 20px 0 40px;
        }

        .page-header-modern {
            padding: 40px 0;
            margin-bottom: 25px;
        }

        .page-header-modern::before {
            width: 200px;
            height: 200px;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-subtitle {
            font-size: 0.85rem;
        }

        .page-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
            border-radius: 14px;
            margin-bottom: 15px;
        }

        .orders-list {
            gap: 15px;
        }

        .order-card {
            border-radius: 12px;
        }

        .order-card:hover {
            transform: none;
        }

        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            gap: 10px;
        }

        .order-number {
            font-size: 0.95rem;
            gap: 8px;
        }

        .order-date {
            font-size: 0.8rem;
        }

        .status-badge {
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .order-card-body {
            padding: 15px;
        }

        .order-info-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }

        .order-info-label {
            font-size: 0.7rem;
        }

        .order-info-value {
            font-size: 0.9rem;
        }

        .order-total {
            font-size: 1.1rem;
        }

        .order-actions {
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
        }

        .btn-view-order,
        .btn-reorder {
            padding: 10px 20px;
            font-size: 0.85rem;
            border-radius: 10px;
        }

        .empty-orders {
            padding: 50px 20px;
            border-radius: 12px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            font-size: 35px;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .empty-description {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .btn-start-shopping {
            padding: 12px 24px;
            font-size: 0.9rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .orders-page {
            padding: 15px 0 30px;
        }

        .page-header-modern {
            padding: 30px 0;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .page-subtitle {
            font-size: 0.8rem;
        }

        .page-icon {
            width: 45px;
            height: 45px;
            font-size: 20px;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .orders-list {
            gap: 12px;
        }

        .order-card-header {
            padding: 12px;
        }

        .order-number {
            font-size: 0.85rem;
        }

        .order-date {
            font-size: 0.75rem;
        }

        .status-badge {
            padding: 5px 10px;
            font-size: 0.7rem;
        }

        .order-card-body {
            padding: 12px;
        }

        .order-info-grid {
            gap: 10px;
        }

        .order-info-label {
            font-size: 0.65rem;
        }

        .order-info-value {
            font-size: 0.8rem;
        }

        .order-total {
            font-size: 1rem;
        }

        .btn-view-order,
        .btn-reorder {
            padding: 9px 16px;
            font-size: 0.8rem;
        }

        .empty-orders {
            padding: 40px 15px;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            font-size: 28px;
        }

        .empty-title {
            font-size: 1.1rem;
        }

        .empty-description {
            font-size: 0.8rem;
        }

        .btn-start-shopping {
            padding: 10px 20px;
            font-size: 0.85rem;
        }
    }

    /* RTL Support */
    [dir="rtl"] .order-number i,
    html[dir="rtl"] .order-number i {
        margin-right: 0;
        margin-left: 10px;
    }

    [dir="rtl"] .order-date i,
    html[dir="rtl"] .order-date i {
        margin-right: 0;
        margin-left: 8px;
    }

    [dir="rtl"] .btn-view-order i,
    html[dir="rtl"] .btn-view-order i {
        transform: scaleX(-1);
    }

    /* ================================
       Mobile Orders Styles
       ================================ */
    .mobile-orders-header {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 30px 16px;
        text-align: center;
        color: white;
    }

    .mobile-orders-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 22px;
    }

    .mobile-orders-header h1 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .mobile-orders-header p {
        font-size: 12px;
        opacity: 0.9;
        margin: 0;
    }

    .mobile-orders-list {
        padding: 16px;
        background: #f8f9fa;
    }

    .mobile-order-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .mobile-order-header {
        padding: 14px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mobile-order-number {
        font-size: 13px;
        font-weight: 600;
        color: #212529;
    }

    .mobile-order-date {
        font-size: 11px;
        color: #6c757d;
    }

    .mobile-status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .mobile-status-pending {
        background: #fef3cd;
        color: #856404;
    }

    .mobile-status-processing {
        background: #cce5ff;
        color: #004085;
    }

    .mobile-status-completed {
        background: #d4edda;
        color: #155724;
    }

    .mobile-status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .mobile-order-body {
        padding: 14px;
    }

    .mobile-order-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 14px;
    }

    .mobile-order-info-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .mobile-order-info-label {
        font-size: 10px;
        color: #6c757d;
        text-transform: uppercase;
    }

    .mobile-order-info-value {
        font-size: 13px;
        font-weight: 600;
        color: #212529;
    }

    .mobile-order-total {
        color: var(--main-color);
        font-size: 16px;
    }

    .mobile-order-view-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        background: var(--main-color);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .mobile-empty-orders {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 14px;
    }

    .mobile-empty-orders i {
        font-size: 50px;
        color: #dee2e6;
        margin-bottom: 16px;
    }

    .mobile-empty-orders h2 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .mobile-empty-orders p {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .mobile-empty-orders a {
        display: inline-block;
        background: var(--main-color);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }
</style>
@endsection

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="orders-page">
    {{-- Page Header --}}
    <div class="page-header-modern">
        <div class="container">
            <div class="page-header-content">
                <div class="page-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h1 class="page-title">{{ __('store.orders.title') }}</h1>
                <p class="page-subtitle">{{ __('store.orders.subtitle') }}</p>
            </div>
        </div>
    </div>

    <div class="container">
        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        {{-- Order Header --}}
                        <div class="order-card-header">
                            <div class="order-number">
                                <i class="fas fa-receipt"></i>
                                {{ __('store.orders.order_number') }}: #{{ $order->id }}
                            </div>
                            <div class="order-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ $order->created_at->format('M d, Y') }}
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

                        {{-- Order Body --}}
                        <div class="order-card-body">
                            <div class="order-info-grid">
                                <div class="order-info-item">
                                    <span class="order-info-label">{{ __('store.orders.total_amount') }}</span>
                                    <span class="order-total">{{ currency_symbol() }}{{ number_format(convert_price($order->total), 2) }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="order-info-label">{{ __('store.orders.payment_method') }}</span>
                                    <span class="order-info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="order-info-label">{{ __('store.orders.payment_status') }}</span>
                                    <span class="order-info-value">{{ ucfirst($order->payment_status) }}</span>
                                </div>

                                <div class="order-info-item">
                                    <span class="order-info-label">{{ __('store.orders.items_count') }}</span>
                                    <span class="order-info-value">{{ $order->details->count() }} {{ __('store.orders.items') }}</span>
                                </div>
                            </div>

                            {{-- Order Actions --}}
                            <div class="order-actions">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="btn-view-order">
                                    <span>{{ __('store.orders.view_details') }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="pagination-container">
                    {{ $orders->links('vendor.pagination.custom') }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="empty-orders">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="empty-title">{{ __('store.orders.no_orders') }}</h2>
                <p class="empty-description">
                    {{ __('store.orders.no_orders_description') }}
                </p>
                <a href="{{ route('xylo.home') }}" class="btn-start-shopping">
                    <i class="fas fa-store"></i>
                    <span>{{ __('store.orders.start_shopping') }}</span>
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

    {{-- Mobile Header --}}
    <div class="mobile-orders-header">
        <div class="mobile-orders-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h1>{{ __('store.orders.title') }}</h1>
        <p>{{ __('store.orders.subtitle') }}</p>
    </div>

    {{-- Mobile Orders List --}}
    <div class="mobile-orders-list">
        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="mobile-order-card">
                    <div class="mobile-order-header">
                        <div>
                            <div class="mobile-order-number">#{{ $order->id }}</div>
                            <div class="mobile-order-date">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        @php
                            $mobileStatusClass = 'mobile-status-' . strtolower($order->status);
                        @endphp
                        <span class="mobile-status-badge {{ $mobileStatusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="mobile-order-body">
                        <div class="mobile-order-info">
                            <div class="mobile-order-info-item">
                                <span class="mobile-order-info-label">{{ __('store.orders.total_amount') }}</span>
                                <span class="mobile-order-info-value mobile-order-total">{{ currency_symbol() }}{{ number_format(convert_price($order->total), 2) }}</span>
                            </div>
                            <div class="mobile-order-info-item">
                                <span class="mobile-order-info-label">{{ __('store.orders.items_count') }}</span>
                                <span class="mobile-order-info-value">{{ $order->details->count() }} {{ __('store.orders.items') }}</span>
                            </div>
                            <div class="mobile-order-info-item">
                                <span class="mobile-order-info-label">{{ __('store.orders.payment_method') }}</span>
                                <span class="mobile-order-info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            </div>
                            <div class="mobile-order-info-item">
                                <span class="mobile-order-info-label">{{ __('store.orders.payment_status') }}</span>
                                <span class="mobile-order-info-value">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('customer.orders.show', $order->id) }}" class="mobile-order-view-btn">
                            {{ __('store.orders.view_details') }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            @if($orders->hasPages())
                <div class="pagination-container">
                    {{ $orders->links('vendor.pagination.custom') }}
                </div>
            @endif
        @else
            <div class="mobile-empty-orders">
                <i class="fas fa-shopping-bag"></i>
                <h2>{{ __('store.orders.no_orders') }}</h2>
                <p>{{ __('store.orders.no_orders_description') }}</p>
                <a href="{{ route('xylo.home') }}">
                    <i class="fas fa-store"></i> {{ __('store.orders.start_shopping') }}
                </a>
            </div>
        @endif
    </div>

</div>
{{-- END MOBILE VERSION --}}

@endsection
