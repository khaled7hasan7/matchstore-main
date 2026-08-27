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

/* Mobile Responsive Checkout */
@media (max-width: 768px) {
    .cart-page {
        padding-top: 1.5rem !important;
        padding-bottom: 2rem !important;
    }

    .banner-area.inner-banner {
        padding-top: 1rem !important;
        padding-bottom: 0.5rem !important;
    }

    .breadcrumbs {
        font-size: 0.8rem;
    }

    .shipping_info {
        padding: 1rem;
        background: #fff;
        border-radius: 10px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .cart-heading {
        font-size: 1.1rem;
        margin-bottom: 1rem !important;
        margin-top: 0 !important;
    }

    .form-control, .form-select {
        font-size: 0.9rem;
        padding: 0.65rem 0.85rem;
    }

    .form-control::placeholder {
        font-size: 0.85rem;
    }

    .row > [class*="col-md-"] {
        margin-bottom: 0;
    }

    .mt-3 {
        margin-top: 0.75rem !important;
    }

    .mt-5 {
        margin-top: 1.5rem !important;
    }

    .cart-box {
        padding: 1.25rem;
        border-radius: 10px;
        margin-top: 1.5rem;
    }

    .form-check-label {
        font-size: 0.9rem;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
    }

    #place-order {
        padding: 0.85rem;
        font-size: 0.95rem;
    }

    #delivery-time-display {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    #paypal-button-container,
    #card-element {
        margin-top: 1rem;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .cart-page {
        padding-top: 1rem !important;
        padding-bottom: 1.5rem !important;
    }

    .breadcrumbs {
        font-size: 0.7rem;
    }

    .breadcrumbs i {
        margin: 0 0.25rem;
    }

    .shipping_info {
        padding: 0.85rem;
    }

    .cart-heading {
        font-size: 1rem;
    }

    .form-control, .form-select {
        font-size: 0.85rem;
        padding: 0.6rem 0.75rem;
    }

    .form-check-label {
        font-size: 0.8rem;
    }

    .cart-box {
        padding: 1rem;
    }

    .cart-box .row {
        font-size: 0.9rem;
    }

    #place-order {
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    .read-more {
        padding: 0.75rem;
        font-size: 0.85rem;
    }
}

/* ================================
   Mobile Checkout Styles
   ================================ */

/* Mobile Checkout Header */
.mobile-checkout-header {
    background: #fff;
    padding: 16px;
    border-bottom: 1px solid #eee;
}

.mobile-checkout-header h1 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #212529;
}

/* Mobile Order Summary Toggle */
.mobile-order-summary-toggle {
    background: var(--main-color);
    color: white;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.mobile-order-summary-toggle span {
    font-size: 14px;
    font-weight: 500;
}

.mobile-order-summary-toggle .total {
    font-weight: 700;
    font-size: 16px;
}

.mobile-order-summary-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #f8f9fa;
}

.mobile-order-summary-toggle.open + .mobile-order-summary-content {
    max-height: 500px;
}

.mobile-order-summary-inner {
    padding: 16px;
}

.mobile-summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.mobile-summary-row:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 15px;
}

/* Mobile Form Sections */
.mobile-checkout-form {
    padding: 16px;
    background: #fff;
}

.mobile-form-section {
    margin-bottom: 20px;
}

.mobile-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.mobile-section-number {
    width: 28px;
    height: 28px;
    background: var(--main-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
}

.mobile-section-title {
    font-size: 16px;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.mobile-form-row {
    margin-bottom: 12px;
}

.mobile-form-row-double {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

.mobile-form-input {
    width: 100%;
    padding: 14px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    transition: border-color 0.2s;
}

.mobile-form-input:focus {
    outline: none;
    border-color: var(--main-color);
}

.mobile-form-select {
    width: 100%;
    padding: 14px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
}

.mobile-form-select:focus {
    outline: none;
    border-color: var(--main-color);
}

.mobile-delivery-badge {
    background: #d1f4e0;
    color: #198754;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
}

.mobile-checkbox-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 12px;
}

.mobile-checkbox-row input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--main-color);
}

.mobile-checkbox-row label {
    font-size: 13px;
    color: #495057;
}

/* Mobile Payment Methods */
.mobile-payment-methods {
    margin-top: 12px;
}

.mobile-payment-option {
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.mobile-payment-option.selected {
    border-color: var(--main-color);
    background: rgba(var(--main-color-rgb), 0.05);
}

.mobile-payment-option input[type="radio"] {
    display: none;
}

.mobile-payment-radio {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.mobile-payment-option.selected .mobile-payment-radio {
    border-color: var(--main-color);
}

.mobile-payment-option.selected .mobile-payment-radio::after {
    content: '';
    width: 10px;
    height: 10px;
    background: var(--main-color);
    border-radius: 50%;
}

.mobile-payment-label {
    font-size: 14px;
    font-weight: 500;
    flex: 1;
}

.mobile-payment-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.mobile-payment-option.selected .mobile-payment-content {
    max-height: 300px;
    padding-top: 12px;
    margin-top: 12px;
    border-top: 1px solid #eee;
}

/* Mobile Sticky Checkout Bar */
.mobile-checkout-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    padding: 12px 16px;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    z-index: 100;
    display: none;
}

@media (max-width: 768px) {
    .mobile-checkout-bar {
        display: block;
    }
}

.mobile-checkout-bar-inner {
    display: flex;
    align-items: center;
    gap: 16px;
}

.mobile-checkout-total {
    flex: 1;
}

.mobile-checkout-total .label {
    font-size: 12px;
    color: #6c757d;
}

.mobile-checkout-total .amount {
    font-size: 18px;
    font-weight: 700;
    color: var(--main-color);
}

.mobile-place-order-btn {
    flex: 2;
    background: var(--main-color);
    color: white;
    border: none;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.mobile-place-order-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Add padding at bottom for sticky bar */
.mobile-only.mobile-checkout-page {
    padding-bottom: 90px;
}

/* Mobile No Payment Warning */
.mobile-no-payment-warning {
    background: #fff3cd;
    color: #856404;
    padding: 14px;
    border-radius: 10px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-form-row-double {
        grid-template-columns: 1fr;
    }

    .mobile-form-input,
    .mobile-form-select {
        padding: 12px;
        font-size: 13px;
    }

    .mobile-section-title {
        font-size: 15px;
    }

    .mobile-payment-label {
        font-size: 13px;
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
    <section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-4">
                    <div class="breadcrumbs">
                        <a href="#">{{ __('store.checkout.breadcrumb_home') }}</a> <i class="fa fa-angle-right"></i> <a href="#">{{ __('store.checkout.breadcrumb_category') }}</a> <i
                            class="fa fa-angle-right"></i>{{ __('store.checkout.breadcrumb_checkout') }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="cart-page pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                        @csrf

                        <!-- Shipping Information -->
                        <div class="shipping_info">
                            <h3 class="cart-heading">{{ __('store.checkout.shipping_information') }}</h3>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <input type="text" name="first_name" class="form-control" placeholder="{{ __('store.checkout.first_name') }}" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <input type="text" name="last_name" class="form-control" placeholder="{{ __('store.checkout.last_name') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <input type="text" name="address" class="form-control" placeholder="{{ __('store.checkout.address') }}" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <input type="text" name="suite" class="form-control" placeholder="{{ __('store.checkout.suite') }}">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <select name="country" id="shipping-country" class="form-select" required>
                                        <option value="">{{ __('store.checkout.select_country') }}</option>
                                        <option value="jordan">{{ __('store.checkout.jordan') }}</option>
                                        <option value="palestine">{{ __('store.checkout.palestine') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <select name="region_id" id="shipping-region" class="form-select" required disabled>
                                        <option value="">{{ __('store.checkout.select_region_first') }}</option>
                                    </select>
                                    <input type="hidden" name="city" id="city-name">
                                </div>
                                <div class="col-md-3 mt-3">
                                    <input type="text" name="zipcode" class="form-control" placeholder="{{ __('store.checkout.zipcode') }}">
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-control bg-light" id="delivery-time-display">
                                        <small class="text-muted">{{ __('store.checkout.delivery_days') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label>
                                    <input type="checkbox" name="use_as_billing" value="1" checked>{{ __('store.checkout.use_as_billing') }}
                                </label>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="shipping_info">
                            <h3 class="cart-heading mt-5">{{ __('store.checkout.contact_information') }}</h3>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('store.checkout.email') }}" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <input type="text" name="phone" class="form-control" placeholder="{{ __('store.checkout.phone') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="shipping_info mt-5">
                            <h3 class="cart-heading">{{ __('store.checkout.payment_method') }}</h3>

                            @if($paymentGateways->isEmpty())
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ __('store.checkout.no_payment_gateways') }}
                                </div>
                            @else
                                @foreach($paymentGateways as $gateway)
                                    <div class="form-check mt-2">
                                        <input type="radio" name="gateway" value="{{ $gateway->code }}"
                                            id="gateway-{{ $gateway->id }}" class="form-check-input" required>
                                        <label class="form-check-label" for="gateway-{{ $gateway->id }}">{{ $gateway->name }}</label>
                                    </div>

                                    @if($gateway->code === 'paypal')
                                        <div id="paypal-button-container" class="mt-3" style="display: none;"></div>
                                    @endif

                                    @if($gateway->code === 'stripe')
                                        <div id="card-element" class="mt-3" style="display: none;"></div>
                                        <div id="card-errors" class="text-danger mt-2"></div>
                                    @endif
                                @endforeach
                            @endif

                            <div id="payment-fields">
                                <!-- Stripe/PayPal fields injected with JS -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" id="place-order" class="btn btn-primary w-100">{{ __('store.checkout.place_order') }}</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-5 mt-5 mt-md-0">
                    <div class="cart-box">
                        <h3 class="cart-heading">{{ __('store.checkout.order_summary') }}</h3>

                        <div class="row border-bottom pb-2 mb-2 mt-4">
                            <div class="col-6 col-md-4">{{ __('store.checkout.subtotal') }}</div>
                            <div class="col-6 col-md-8 text-end" id="subtotal-display">${{ number_format($subtotal, 2) }}</div>
                        </div>
                        @if($discount > 0)
                        <div class="row border-bottom pb-2 mb-2 text-success">
                            <div class="col-6 col-md-6">{{ __('store.checkout.discount') }} ({{ $coupon->code }})</div>
                            <div class="col-6 col-md-6 text-end">-${{ number_format($discount, 2) }}</div>
                        </div>
                        @endif
                        <div class="row border-bottom pb-2 mb-2">
                            <div class="col-4 col-md-4">{{ __('store.checkout.shipping') }}</div>
                            <div class="col-8 col-md-8 text-end" id="shipping-cost-display">
                                <small>{{ __('store.checkout.select_location') }}</small>
                            </div>
                        </div>
                        <div class="row border-bottom pb-2 mb-2">
                            <div class="col-6 col-md-4">{{ __('store.checkout.total') }}</div>
                            <div class="col-6 col-md-8 text-end"><span id="total-display">${{ number_format($total, 2) }}</span></div>
                        </div>

                        <div class="mt-4">
                            <a href="#" class="read-more d-block text-center">{{ __('store.checkout.proceed') }}</a>
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
    <div class="mobile-only mobile-checkout-page">

        {{-- Mobile Checkout Header --}}
        <div class="mobile-checkout-header">
            <h1>{{ __('store.checkout.breadcrumb_checkout') }}</h1>
        </div>

        {{-- Mobile Order Summary Toggle --}}
        <div class="mobile-order-summary-toggle" onclick="this.classList.toggle('open')">
            <span><i class="fas fa-shopping-bag"></i> {{ __('store.checkout.order_summary') }}</span>
            <span class="total">{{ $currency->symbol }}{{ number_format($total, 2) }}</span>
        </div>
        <div class="mobile-order-summary-content">
            <div class="mobile-order-summary-inner">
                <div class="mobile-summary-row">
                    <span>{{ __('store.checkout.subtotal') }}</span>
                    <span id="mobile-subtotal-display">{{ $currency->symbol }}{{ number_format($subtotal, 2) }}</span>
                </div>
                @if($discount > 0)
                <div class="mobile-summary-row text-success">
                    <span>{{ __('store.checkout.discount') }} ({{ $coupon->code }})</span>
                    <span>-{{ $currency->symbol }}{{ number_format($discount, 2) }}</span>
                </div>
                @endif
                <div class="mobile-summary-row">
                    <span>{{ __('store.checkout.shipping') }}</span>
                    <span id="mobile-shipping-display">{{ __('store.checkout.select_location') }}</span>
                </div>
                <div class="mobile-summary-row">
                    <span>{{ __('store.checkout.total') }}</span>
                    <span id="mobile-total-display">{{ $currency->symbol }}{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Mobile Checkout Form --}}
        <form id="mobile-checkout-form" method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <div class="mobile-checkout-form">

                {{-- Shipping Information --}}
                <div class="mobile-form-section">
                    <div class="mobile-section-header">
                        <span class="mobile-section-number">1</span>
                        <h2 class="mobile-section-title">{{ __('store.checkout.shipping_information') }}</h2>
                    </div>

                    <div class="mobile-form-row-double">
                        <input type="text" name="first_name" class="mobile-form-input" placeholder="{{ __('store.checkout.first_name') }}" required>
                        <input type="text" name="last_name" class="mobile-form-input" placeholder="{{ __('store.checkout.last_name') }}" required>
                    </div>

                    <div class="mobile-form-row">
                        <input type="text" name="address" class="mobile-form-input" placeholder="{{ __('store.checkout.address') }}" required>
                    </div>

                    <div class="mobile-form-row-double">
                        <input type="text" name="suite" class="mobile-form-input" placeholder="{{ __('store.checkout.suite') }}">
                        <select name="country" id="mobile-shipping-country" class="mobile-form-select" required>
                            <option value="">{{ __('store.checkout.select_country') }}</option>
                            <option value="jordan">{{ __('store.checkout.jordan') }}</option>
                            <option value="palestine">{{ __('store.checkout.palestine') }}</option>
                        </select>
                    </div>

                    <div class="mobile-form-row-double">
                        <select name="region_id" id="mobile-shipping-region" class="mobile-form-select" required disabled>
                            <option value="">{{ __('store.checkout.select_region_first') }}</option>
                        </select>
                        <input type="hidden" name="city" id="mobile-city-name">
                        <input type="text" name="zipcode" class="mobile-form-input" placeholder="{{ __('store.checkout.zipcode') }}">
                    </div>

                    <div class="mobile-delivery-badge" id="mobile-delivery-badge" style="display: none;">
                        <i class="fas fa-truck"></i>
                        <span id="mobile-delivery-time">{{ __('store.checkout.delivery_days') }}</span>
                    </div>

                    <div class="mobile-checkbox-row">
                        <input type="checkbox" name="use_as_billing" value="1" checked id="mobile-use-billing">
                        <label for="mobile-use-billing">{{ __('store.checkout.use_as_billing') }}</label>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="mobile-form-section">
                    <div class="mobile-section-header">
                        <span class="mobile-section-number">2</span>
                        <h2 class="mobile-section-title">{{ __('store.checkout.contact_information') }}</h2>
                    </div>

                    <div class="mobile-form-row-double">
                        <input type="email" name="email" class="mobile-form-input" placeholder="{{ __('store.checkout.email') }}" required>
                        <input type="tel" name="phone" class="mobile-form-input" placeholder="{{ __('store.checkout.phone') }}" required>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="mobile-form-section">
                    <div class="mobile-section-header">
                        <span class="mobile-section-number">3</span>
                        <h2 class="mobile-section-title">{{ __('store.checkout.payment_method') }}</h2>
                    </div>

                    @if($paymentGateways->isEmpty())
                        <div class="mobile-no-payment-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ __('store.checkout.no_payment_gateways') }}
                        </div>
                    @else
                        <div class="mobile-payment-methods">
                            @foreach($paymentGateways as $gateway)
                                <div class="mobile-payment-option" onclick="selectMobilePayment(this, '{{ $gateway->code }}')">
                                    <input type="radio" name="gateway" value="{{ $gateway->code }}" id="mobile-gateway-{{ $gateway->id }}" required>
                                    <div class="mobile-payment-radio"></div>
                                    <span class="mobile-payment-label">{{ $gateway->name }}</span>

                                    @if($gateway->code === 'paypal')
                                        <div class="mobile-payment-content">
                                            <div id="mobile-paypal-button-container"></div>
                                        </div>
                                    @endif

                                    @if($gateway->code === 'stripe')
                                        <div class="mobile-payment-content">
                                            <div id="mobile-card-element"></div>
                                            <div id="mobile-card-errors" class="text-danger mt-2" style="font-size: 12px;"></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </form>

    </div>
    {{-- END MOBILE VERSION --}}

    {{-- Mobile Checkout Bar --}}
    <div class="mobile-checkout-bar">
        <div class="mobile-checkout-bar-inner">
            <div class="mobile-checkout-total">
                <div class="label">{{ __('store.checkout.total') }}</div>
                <div class="amount" id="mobile-bar-total">{{ $currency->symbol }}{{ number_format($total, 2) }}</div>
            </div>
            <button type="button" class="mobile-place-order-btn" onclick="submitMobileCheckout()">
                <i class="fas fa-lock"></i>
                {{ __('store.checkout.place_order') }}
            </button>
        </div>
    </div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
// Shipping region and cost calculation
document.addEventListener("DOMContentLoaded", function () {
    const countrySelect = document.getElementById('shipping-country');
    const regionSelect = document.getElementById('shipping-region');
    const cityNameInput = document.getElementById('city-name');
    const deliveryTimeDisplay = document.getElementById('delivery-time-display');
    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = {{ $subtotal }};
    const discount = {{ $discount ?? 0 }};

    let currentShippingCost = 0;
    let selectedRegion = null;

    // Load regions when country is selected
    countrySelect.addEventListener('change', function() {
        const country = this.value;

        if (!country) {
            regionSelect.disabled = true;
            regionSelect.innerHTML = '<option value="">{{ __('store.checkout.select_region_first') }}</option>';
            return;
        }

        // Fetch regions for selected country
        fetch(`/api/shipping/regions/${country}`)
            .then(response => response.json())
            .then(data => {
                regionSelect.disabled = false;
                regionSelect.innerHTML = '<option value="">{{ __('store.checkout.select_region') }}</option>';

                data.regions.forEach(region => {
                    const option = document.createElement('option');
                    option.value = region.id;
                    option.textContent = '{{ app()->getLocale() }}' === 'ar' ? region.name_ar : region.name;
                    option.dataset.baseCost = region.base_cost;
                    option.dataset.deliveryDays = region.delivery_days;
                    option.dataset.nameEn = region.name;
                    option.dataset.nameAr = region.name_ar;
                    regionSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading regions:', error);
                toastr.error('{{ __('store.checkout.error_loading_regions') }}');
            });
    });

    // Calculate shipping when region is selected
    regionSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (!this.value) {
            currentShippingCost = 0;
            shippingCostDisplay.innerHTML = '<small>{{ __('store.checkout.select_location') }}</small>';
            deliveryTimeDisplay.innerHTML = '<small class="text-muted">{{ __('store.checkout.delivery_days') }}</small>';
            updateTotal();
            return;
        }

        const regionId = this.value;
        const baseCost = parseFloat(selectedOption.dataset.baseCost);
        const deliveryDays = selectedOption.dataset.deliveryDays;

        // Store city name in hidden field
        cityNameInput.value = '{{ app()->getLocale() }}' === 'ar' ? selectedOption.dataset.nameAr : selectedOption.dataset.nameEn;

        // Calculate shipping cost (you can add weight calculation here if needed)
        const weight = 1; // Default weight, can be calculated from cart

        fetch(`/api/shipping/calculate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                region_id: regionId,
                weight: weight
            })
        })
        .then(response => response.json())
        .then(data => {
            currentShippingCost = data.shipping_cost;
            shippingCostDisplay.textContent = '$' + currentShippingCost.toFixed(2);
            deliveryTimeDisplay.innerHTML = '<small>' + deliveryDays + ' {{ __('store.checkout.days') }}</small>';
            updateTotal();
        })
        .catch(error => {
            console.error('Error calculating shipping:', error);
            toastr.error('{{ __('store.checkout.error_calculating_shipping') }}');
        });
    });

    function updateTotal() {
        const total = Math.max(0, subtotal - discount) + currentShippingCost;
        totalDisplay.textContent = '$' + total.toFixed(2);
    }
});
</script>
<?php /* ?>
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener("DOMContentLoaded", async () => {
    // Fetch keys from backend
    let response = await fetch("{{ route('stripe.checkout.process') }}");
    let data = await response.json();

    let stripe = Stripe(data.publicKey);
    let elements = stripe.elements();
    let cardElement = elements.create('card');
    cardElement.mount('#card-element');

    document.querySelector('#checkout-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const {error, paymentIntent} = await stripe.confirmCardPayment(data.clientSecret, {
            payment_method: {
                card: cardElement
            }
        });

        if (error) {
            alert(error.message);
        } else if (paymentIntent.status === 'succeeded') {
            alert("Payment successful!");
            window.location.href = "/order/success";
        }
    });
});
</script>


@if($paypalClientId)
    <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=USD"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof paypal !== "undefined") {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{ amount: { value: "{{ $total }}" } }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            fetch("{{ route('checkout.process') }}", {
                                method: "POST",
                                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                body: JSON.stringify({
                                    gateway: "paypal",
                                    order_id: data.orderID
                                })
                            });
                        });
                    }
                }).render('#paypal-button-container');
            } else {
                console.error("PayPal SDK not loaded");
            }
        });
    </script>
@endif
<?php */ ?>
@if(!empty($paypalClientId))
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=USD"></script>
@endif
@if(!empty($stripePublicKey))
<script src="https://js.stripe.com/v3/"></script>
@endif
<script>
document.addEventListener("DOMContentLoaded", function () {
    const gatewayRadios = document.querySelectorAll('input[name="gateway"]');
    const paypalContainer = document.getElementById("paypal-button-container");
    const stripeContainer = document.getElementById("card-element");

    // Stripe/PayPal are initialized only when the gateway is active and
    // actually configured, so a missing key can never break COD checkout.
    let stripe = null;
    let card = null;

    @if(!empty($stripePublicKey))
    if (stripeContainer && typeof Stripe !== "undefined") {
        stripe = Stripe(@json($stripePublicKey));
        let elements = stripe.elements();
        card = elements.create("card");
        card.mount("#card-element");
    }
    @endif

    // Show correct payment fields
    gatewayRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (paypalContainer) {
                paypalContainer.style.display = this.value === "paypal" ? "block" : "none";
            }
            if (stripeContainer) {
                stripeContainer.style.display = this.value === "stripe" ? "block" : "none";
            }
        });
    });

    // PayPal integration
    if (typeof paypal !== "undefined" && paypalContainer) {
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{ amount: { value: "{{ number_format($total, 2, '.', '') }}" } }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Send to backend
                    fetch("{{ route('checkout.process') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            gateway: "paypal",
                            order_id: data.orderID,
                            details: details
                        })
                    }).then(res => res.json()).then(result => {
                        window.location.href = "/thank-you";
                    });
                });
            }
        }).render("#paypal-button-container");
    }

    // Stripe integration — COD submits the form natively
    const form = document.getElementById("checkout-form");
    form.addEventListener("submit", async function (e) {
        const checked = document.querySelector('input[name="gateway"]:checked');

        if (!checked) {
            return; // let native "required" validation handle it
        }

        if (checked.value === "stripe" && stripe && card) {
            e.preventDefault();

            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: "card",
                card: card,
            });

            if (error) {
                document.getElementById("card-errors").textContent = error.message;
            } else {
                // Send paymentMethod.id + form data to backend
                let formData = new FormData(form);
                formData.append("payment_method_id", paymentMethod.id);

                fetch("{{ route('checkout.process') }}", {
                    method: "POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    body: formData
                }).then(res => res.json()).then(result => {
                    window.location.href = "/thank-you";
                });
            }
        } else if (checked.value === "paypal") {
            e.preventDefault();
            alert("{{ __('store.checkout.paypal_instructions') }}");
        }
    });
});
</script>

@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    toastr.error(@json(session('error')));
});
</script>
@endif
@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    toastr.success(@json(session('success')));
});
</script>
@endif

<script>
// ================================
// MOBILE CHECKOUT FUNCTIONS
// ================================

// Mobile Payment Selection
function selectMobilePayment(element, code) {
    // Remove selected class from all options
    document.querySelectorAll('.mobile-payment-option').forEach(opt => {
        opt.classList.remove('selected');
    });

    // Add selected class to clicked option
    element.classList.add('selected');

    // Check the radio button
    element.querySelector('input[type="radio"]').checked = true;
}

// Mobile Form Submission
function submitMobileCheckout() {
    const form = document.getElementById('mobile-checkout-form');

    // Check if form is valid
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Check if payment method is selected
    const selectedGateway = document.querySelector('#mobile-checkout-form input[name="gateway"]:checked');
    if (!selectedGateway) {
        toastr.error("{{ __('store.checkout.select_payment_method') ?? 'Please select a payment method' }}", "", {
            positionClass: "toast-top-center"
        });
        return;
    }

    // Submit form
    form.submit();
}

// Mobile Shipping Region Handler
document.addEventListener("DOMContentLoaded", function() {
    const mobileCountrySelect = document.getElementById('mobile-shipping-country');
    const mobileRegionSelect = document.getElementById('mobile-shipping-region');
    const mobileCityInput = document.getElementById('mobile-city-name');
    const mobileDeliveryBadge = document.getElementById('mobile-delivery-badge');
    const mobileDeliveryTime = document.getElementById('mobile-delivery-time');
    const mobileShippingDisplay = document.getElementById('mobile-shipping-display');
    const mobileTotalDisplay = document.getElementById('mobile-total-display');
    const mobileBarTotal = document.getElementById('mobile-bar-total');
    const subtotal = {{ $subtotal }};
    const discount = {{ $discount ?? 0 }};

    let mobileShippingCost = 0;

    if (mobileCountrySelect) {
        mobileCountrySelect.addEventListener('change', function() {
            const country = this.value;

            if (!country) {
                mobileRegionSelect.disabled = true;
                mobileRegionSelect.innerHTML = '<option value="">{{ __('store.checkout.select_region_first') }}</option>';
                return;
            }

            fetch(`/api/shipping/regions/${country}`)
                .then(response => response.json())
                .then(data => {
                    mobileRegionSelect.disabled = false;
                    mobileRegionSelect.innerHTML = '<option value="">{{ __('store.checkout.select_region') }}</option>';

                    data.regions.forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.id;
                        option.textContent = '{{ app()->getLocale() }}' === 'ar' ? region.name_ar : region.name;
                        option.dataset.baseCost = region.base_cost;
                        option.dataset.deliveryDays = region.delivery_days;
                        option.dataset.nameEn = region.name;
                        option.dataset.nameAr = region.name_ar;
                        mobileRegionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading regions:', error);
                    toastr.error('{{ __('store.checkout.error_loading_regions') }}', "", {
                        positionClass: "toast-top-center"
                    });
                });
        });
    }

    if (mobileRegionSelect) {
        mobileRegionSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (!this.value) {
                mobileShippingCost = 0;
                mobileShippingDisplay.textContent = '{{ __('store.checkout.select_location') }}';
                mobileDeliveryBadge.style.display = 'none';
                updateMobileTotal();
                return;
            }

            const regionId = this.value;
            const deliveryDays = selectedOption.dataset.deliveryDays;

            mobileCityInput.value = '{{ app()->getLocale() }}' === 'ar' ? selectedOption.dataset.nameAr : selectedOption.dataset.nameEn;

            fetch(`/api/shipping/calculate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    region_id: regionId,
                    weight: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                mobileShippingCost = data.shipping_cost;
                mobileShippingDisplay.textContent = '$' + mobileShippingCost.toFixed(2);
                mobileDeliveryTime.textContent = deliveryDays + ' {{ __('store.checkout.days') }}';
                mobileDeliveryBadge.style.display = 'flex';
                updateMobileTotal();
            })
            .catch(error => {
                console.error('Error calculating shipping:', error);
                toastr.error('{{ __('store.checkout.error_calculating_shipping') }}', "", {
                    positionClass: "toast-top-center"
                });
            });
        });
    }

    function updateMobileTotal() {
        const total = Math.max(0, subtotal - discount) + mobileShippingCost;
        const formattedTotal = '$' + total.toFixed(2);
        mobileTotalDisplay.textContent = formattedTotal;
        if (mobileBarTotal) {
            mobileBarTotal.textContent = formattedTotal;
        }
    }
});
</script>

@endsection