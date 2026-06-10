@extends('themes.xylo.layouts.master')

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

/* ================================
   Mobile Order Confirmation Styles
   ================================ */

.mobile-confirmation-page {
    min-height: 100vh;
    background: #f8f9fa;
}

/* Mobile Success Header */
.mobile-success-header {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
    padding: 40px 20px;
    text-align: center;
    color: white;
}

.mobile-success-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 40px;
}

.mobile-success-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 8px;
}

.mobile-success-message {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 16px;
}

.mobile-order-number-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.25);
    padding: 10px 24px;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
}

/* Mobile Confirmation Content */
.mobile-confirmation-content {
    padding: 16px;
    padding-bottom: 100px;
}

/* Mobile Info Card */
.mobile-info-card {
    background: white;
    border-radius: 14px;
    margin-bottom: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

.mobile-info-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
    font-weight: 600;
    color: #212529;
}

.mobile-info-card-header i {
    color: var(--main-color);
    font-size: 14px;
}

.mobile-info-card-body {
    padding: 14px 16px;
}

/* Mobile Info Row */
.mobile-conf-info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.mobile-conf-info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.mobile-conf-info-row:first-child {
    padding-top: 0;
}

.mobile-conf-label {
    font-size: 13px;
    color: #6c757d;
}

.mobile-conf-value {
    font-size: 13px;
    color: #212529;
    font-weight: 500;
    text-align: right;
    max-width: 60%;
}

/* Mobile Order Item */
.mobile-conf-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.mobile-conf-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.mobile-conf-item:first-child {
    padding-top: 0;
}

.mobile-conf-item-name {
    font-size: 14px;
    color: #212529;
    flex: 1;
}

.mobile-conf-item-qty {
    font-size: 12px;
    color: #6c757d;
    margin: 0 12px;
}

.mobile-conf-item-price {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
}

/* Mobile Total Row */
.mobile-conf-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background: #f8f9fa;
    border-top: 2px solid #eee;
}

.mobile-conf-total-label {
    font-size: 15px;
    font-weight: 600;
    color: #212529;
}

.mobile-conf-total-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--main-color);
}

/* Mobile Continue Button */
.mobile-continue-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px;
    background: var(--main-color);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 10px;
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-success-header {
        padding: 30px 16px;
    }

    .mobile-success-icon {
        width: 70px;
        height: 70px;
        font-size: 35px;
    }

    .mobile-success-title {
        font-size: 20px;
    }

    .mobile-success-message {
        font-size: 13px;
    }

    .mobile-order-number-badge {
        font-size: 14px;
        padding: 8px 20px;
    }

    .mobile-confirmation-content {
        padding: 12px;
    }

    .mobile-info-card {
        border-radius: 12px;
    }

    .mobile-conf-info-row,
    .mobile-conf-item {
        padding: 8px 0;
    }

    .mobile-conf-total-value {
        font-size: 18px;
    }
}
</style>
@endsection

@section('content')
    @php $currency = activeCurrency(); @endphp

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
    <div class="order-confirmation-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Message -->
                    <div class="success-card text-center mb-4">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="success-title">{{ __('store.order_confirmation.thank_you') }}</h1>
                        <p class="success-message">{{ __('store.order_confirmation.order_received') }}</p>
                        <div class="order-number">
                            {{ __('store.order_confirmation.order_number') }}: <strong>#{{ $order->id }}</strong>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="order-details-card">
                        <h3 class="section-title">{{ __('store.order_confirmation.order_details') }}</h3>

                        <div class="row">
                            <!-- Shipping Information -->
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <h5>{{ __('store.order_confirmation.shipping_address') }}</h5>
                                    <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p class="mb-1">{{ $order->address }}</p>
                                    @if($order->suite)
                                        <p class="mb-1">{{ $order->suite }}</p>
                                    @endif
                                    <p class="mb-1">{{ $order->city }}, {{ $order->zipcode }}</p>
                                    <p class="mb-1">{{ $order->country }}</p>
                                    <p class="mb-0"><strong>{{ __('store.order_confirmation.phone') }}:</strong> {{ $order->phone }}</p>
                                    <p class="mb-0"><strong>{{ __('store.order_confirmation.email') }}:</strong> {{ $order->email }}</p>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <h5>{{ __('store.order_confirmation.payment_info') }}</h5>
                                    <p class="mb-1">
                                        <strong>{{ __('store.order_confirmation.payment_method') }}:</strong>
                                        @if($order->payment_method === 'cod')
                                            {{ __('store.checkout.cod') }}
                                        @elseif($order->payment_method === 'paypal')
                                            {{ __('store.checkout.paypal') }}
                                        @elseif($order->payment_method === 'stripe')
                                            {{ __('store.checkout.stripe') }}
                                        @else
                                            {{ ucfirst($order->payment_method) }}
                                        @endif
                                    </p>
                                    <p class="mb-1">
                                        <strong>{{ __('store.order_confirmation.payment_status') }}:</strong>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        <strong>{{ __('store.order_confirmation.order_status') }}:</strong>
                                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items">
                            <h5 class="mb-3">{{ __('store.order_confirmation.items_ordered') }}</h5>
                            <div class="table-responsive">
                                <table class="table order-items-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('store.order_confirmation.product') }}</th>
                                            <th class="text-center">{{ __('store.order_confirmation.quantity') }}</th>
                                            <th class="text-end">{{ __('store.order_confirmation.price') }}</th>
                                            <th class="text-end">{{ __('store.order_confirmation.subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order->details as $detail)
                                            <tr>
                                                <td>
                                                    <div class="product-info">
                                                        @if($detail->product)
                                                            @php
                                                                $translation = $detail->product->translations->firstWhere('language_code', app()->getLocale());
                                                                $productName = $translation->name ?? $detail->product->translations->first()->name ?? 'Product #' . $detail->product_id;
                                                            @endphp
                                                            <strong>{{ $productName }}</strong>
                                                        @else
                                                            <strong>Product #{{ $detail->product_id }}</strong>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $detail->quantity }}</td>
                                                <td class="text-end">{{ $currency->symbol }}{{ number_format($detail->price, 2) }}</td>
                                                <td class="text-end">{{ $currency->symbol }}{{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No items found in this order.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="3" class="text-end"><strong>{{ __('store.order_confirmation.total') }}:</strong></td>
                                            <td class="text-end"><strong>{{ $currency->symbol }}{{ number_format($order->total, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons text-center mt-4">
                        <a href="{{ route('xylo.home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>{{ __('store.order_confirmation.continue_shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-confirmation-page {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 80vh;
        }

        .success-card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease;
        }

        .success-icon {
            font-size: 5rem;
            color: var(--main-color);
            margin-bottom: 1.5rem;
            animation: scaleIn 0.5s ease;
        }

        .success-icon i {
            filter: drop-shadow(0 4px 8px rgba(132, 204, 22, 0.3));
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .success-message {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .order-number {
            display: inline-block;
            background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(132, 204, 22, 0.3);
        }

        .order-details-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease 0.2s backwards;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 1rem;
            border-left: 4px solid var(--main-color);
        }

        .info-section h5 {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .info-section p {
            color: #475569;
            font-size: 0.95rem;
        }

        .order-items {
            margin-top: 2rem;
        }

        .order-items-table {
            margin-bottom: 0;
        }

        .order-items-table thead {
            background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
            color: white;
        }

        .order-items-table thead th {
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .order-items-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        .order-items-table tfoot .total-row {
            background: #f8fafc;
            font-size: 1.1rem;
        }

        .order-items-table tfoot td {
            padding: 1.25rem 1rem;
            border-top: 2px solid #cbd5e1;
        }

        .action-buttons {
            animation: fadeInUp 0.6s ease 0.4s backwards;
        }

        .action-buttons .btn {
            padding: 0.875rem 2.5rem;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
            border: none;
            transition: all 0.3s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(132, 204, 22, 0.4);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .success-title {
                font-size: 1.75rem;
            }

            .order-details-card {
                padding: 1.5rem;
            }

            .info-section {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only">
    <div class="mobile-confirmation-page">

        {{-- Mobile Success Header --}}
        <div class="mobile-success-header">
            <div class="mobile-success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="mobile-success-title">{{ __('store.order_confirmation.thank_you') }}</h1>
            <p class="mobile-success-message">{{ __('store.order_confirmation.order_received') }}</p>
            <div class="mobile-order-number-badge">
                {{ __('store.order_confirmation.order_number') }}: #{{ $order->id }}
            </div>
        </div>

        {{-- Mobile Confirmation Content --}}
        <div class="mobile-confirmation-content">

            {{-- Mobile Shipping Address Card --}}
            <div class="mobile-info-card">
                <div class="mobile-info-card-header">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ __('store.order_confirmation.shipping_address') }}
                </div>
                <div class="mobile-info-card-body">
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.name') ?? 'Name' }}</span>
                        <span class="mobile-conf-value">{{ $order->first_name }} {{ $order->last_name }}</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.address') ?? 'Address' }}</span>
                        <span class="mobile-conf-value">{{ $order->address }}@if($order->suite), {{ $order->suite }}@endif</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.city') ?? 'City' }}</span>
                        <span class="mobile-conf-value">{{ $order->city }}, {{ $order->zipcode }}</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.country') ?? 'Country' }}</span>
                        <span class="mobile-conf-value">{{ $order->country }}</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.phone') }}</span>
                        <span class="mobile-conf-value">{{ $order->phone }}</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.email') }}</span>
                        <span class="mobile-conf-value">{{ $order->email }}</span>
                    </div>
                </div>
            </div>

            {{-- Mobile Payment Info Card --}}
            <div class="mobile-info-card">
                <div class="mobile-info-card-header">
                    <i class="fas fa-credit-card"></i>
                    {{ __('store.order_confirmation.payment_info') }}
                </div>
                <div class="mobile-info-card-body">
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.payment_method') }}</span>
                        <span class="mobile-conf-value">
                            @if($order->payment_method === 'cod')
                                {{ __('store.checkout.cod') }}
                            @elseif($order->payment_method === 'paypal')
                                {{ __('store.checkout.paypal') }}
                            @elseif($order->payment_method === 'stripe')
                                {{ __('store.checkout.stripe') }}
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.payment_status') }}</span>
                        <span class="mobile-conf-value">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    <div class="mobile-conf-info-row">
                        <span class="mobile-conf-label">{{ __('store.order_confirmation.order_status') }}</span>
                        <span class="mobile-conf-value">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            </div>

            {{-- Mobile Order Items Card --}}
            <div class="mobile-info-card">
                <div class="mobile-info-card-header">
                    <i class="fas fa-box"></i>
                    {{ __('store.order_confirmation.items_ordered') }}
                </div>
                <div class="mobile-info-card-body">
                    @forelse($order->details as $detail)
                        <div class="mobile-conf-item">
                            <div class="mobile-conf-item-name">
                                @if($detail->product)
                                    @php
                                        $translation = $detail->product->translations->firstWhere('language_code', app()->getLocale());
                                        $productName = $translation->name ?? $detail->product->translations->first()->name ?? 'Product #' . $detail->product_id;
                                    @endphp
                                    {{ $productName }}
                                @else
                                    Product #{{ $detail->product_id }}
                                @endif
                            </div>
                            <span class="mobile-conf-item-qty">x{{ $detail->quantity }}</span>
                            <span class="mobile-conf-item-price">{{ $currency->symbol }}{{ number_format($detail->price * $detail->quantity, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-center text-muted">No items found in this order.</p>
                    @endforelse
                </div>
                <div class="mobile-conf-total">
                    <span class="mobile-conf-total-label">{{ __('store.order_confirmation.total') }}</span>
                    <span class="mobile-conf-total-value">{{ $currency->symbol }}{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            {{-- Mobile Continue Shopping Button --}}
            <a href="{{ route('xylo.home') }}" class="mobile-continue-btn">
                <i class="fas fa-home"></i>
                {{ __('store.order_confirmation.continue_shopping') }}
            </a>

        </div>

    </div>
</div>
{{-- END MOBILE VERSION --}}

@endsection
