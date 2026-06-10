@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .order-details-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .order-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-section {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 0.5rem;
            border-left: 4px solid #0d6efd;
            margin-bottom: 1rem;
        }

        .info-section h5 {
            font-weight: 600;
            color: #212529;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .info-section p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .order-items-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }

        .order-items-table tfoot {
            background: #f8f9fa;
            font-weight: 600;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .back-button {
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ __('cms.order_details.back_to_orders') }}
        </a>
    </div>

    <!-- Order Header -->
    <div class="order-details-card">
        <div class="order-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-2">{{ __('cms.order_details.title', ['id' => $order->id]) }}</h4>
                    <p class="text-muted mb-0">
                        <i class="bi bi-calendar3 me-2"></i>{{ $order->created_at->format('F d, Y \a\t H:i') }}
                    </p>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                        ];
                        $color = $statusColors[$order->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $color }} status-badge">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Customer Information -->
            <div class="col-md-6 mb-3">
                <div class="info-section">
                    <h5><i class="bi bi-person-fill me-2"></i>{{ __('cms.order_details.customer_information') }}</h5>
                    @if($order->customer)
                        <p class="mb-1"><strong>{{ __('cms.order_details.name') }}:</strong> {{ $order->customer->name }}</p>
                        <p class="mb-1"><strong>{{ __('cms.order_details.email') }}:</strong> {{ $order->customer->email }}</p>
                        <p class="mb-0"><strong>{{ __('cms.order_details.phone') }}:</strong> {{ $order->customer->phone ?? __('cms.order_details.na') }}</p>
                    @else
                        <p class="mb-1"><strong>{{ __('cms.order_details.name') }}:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                        <p class="mb-1"><strong>{{ __('cms.order_details.email') }}:</strong> {{ $order->email }}</p>
                        <p class="mb-0"><strong>{{ __('cms.order_details.phone') }}:</strong> {{ $order->phone }}</p>
                    @endif
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="col-md-6 mb-3">
                <div class="info-section">
                    <h5><i class="bi bi-geo-alt-fill me-2"></i>{{ __('cms.order_details.shipping_address') }}</h5>
                    <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                    <p class="mb-1">{{ $order->address }}</p>
                    @if($order->suite)
                        <p class="mb-1">{{ $order->suite }}</p>
                    @endif
                    <p class="mb-1">{{ $order->city }}, {{ $order->zipcode }}</p>
                    <p class="mb-0">{{ $order->country }}</p>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="col-md-6 mb-3">
                <div class="info-section">
                    <h5><i class="bi bi-credit-card-fill me-2"></i>{{ __('cms.order_details.payment_information') }}</h5>
                    <p class="mb-1">
                        <strong>{{ __('cms.order_details.payment_method') }}:</strong>
                        @if($order->payment_method === 'cod')
                            {{ __('cms.order_details.payment_methods.cod') }}
                        @elseif($order->payment_method === 'paypal')
                            {{ __('cms.order_details.payment_methods.paypal') }}
                        @elseif($order->payment_method === 'stripe')
                            {{ __('cms.order_details.payment_methods.stripe') }}
                        @else
                            {{ ucfirst($order->payment_method) }}
                        @endif
                    </p>
                    <p class="mb-1">
                        <strong>{{ __('cms.order_details.payment_status') }}:</strong>
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    @if($order->transaction_id)
                        <p class="mb-0"><strong>{{ __('cms.order_details.transaction_id') }}:</strong> {{ $order->transaction_id }}</p>
                    @endif
                </div>
            </div>

            <!-- Billing Address -->
            @if(!$order->use_as_billing && $order->billing_address)
                <div class="col-md-6 mb-3">
                    <div class="info-section">
                        <h5><i class="bi bi-receipt me-2"></i>{{ __('cms.order_details.billing_address') }}</h5>
                        <p class="mb-1">{{ $order->billing_address }}</p>
                        @if($order->billing_suite)
                            <p class="mb-1">{{ $order->billing_suite }}</p>
                        @endif
                        <p class="mb-1">{{ $order->billing_city }}, {{ $order->billing_zipcode }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Order Items -->
    <div class="order-details-card">
        <h5 class="mb-3"><i class="bi bi-cart-fill me-2"></i>{{ __('cms.order_details.order_items') }}</h5>
        <div class="table-responsive">
            <table class="table order-items-table">
                <thead>
                    <tr>
                        <th>{{ __('cms.order_details.product') }}</th>
                        <th class="text-center">{{ __('cms.order_details.quantity') }}</th>
                        <th class="text-end">{{ __('cms.order_details.unit_price') }}</th>
                        <th class="text-end">{{ __('cms.order_details.subtotal') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currency = activeCurrency(); @endphp
                    @forelse($order->details as $detail)
                        <tr>
                            <td>
                                @if($detail->product)
                                    @php
                                        $translation = $detail->product->translations->firstWhere('language_code', app()->getLocale());
                                        $productName = $translation->name ?? $detail->product->translations->first()->name ?? 'Product #' . $detail->product_id;
                                    @endphp
                                    <strong>{{ $productName }}</strong>
                                    @if($detail->attributes)
                                        @php
                                            $attributes = is_string($detail->attributes) ? json_decode($detail->attributes, true) : $detail->attributes;
                                        @endphp
                                        @if(!empty($attributes))
                                            <br>
                                            <small class="text-muted">
                                                @foreach($attributes as $key => $value)
                                                    {{ ucfirst($key) }}: {{ $value }}
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </small>
                                        @endif
                                    @endif
                                @else
                                    <strong>Product #{{ $detail->product_id }}</strong>
                                    <br><small class="text-danger">{{ __('cms.order_details.product_not_available') }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-end">{{ $currency->symbol }}{{ number_format($detail->price, 2) }}</td>
                            <td class="text-end">{{ $currency->symbol }}{{ number_format($detail->price * $detail->quantity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                {{ __('cms.order_details.no_items') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>{{ __('cms.order_details.total') }}:</strong></td>
                        <td class="text-end"><strong>{{ $currency->symbol }}{{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Order Actions -->
    <div class="order-details-card">
        <h5 class="mb-3"><i class="bi bi-gear-fill me-2"></i>{{ __('cms.order_details.order_actions') }}</h5>
        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex align-items-center gap-3">
            @csrf
            @method('PATCH')
            <div class="flex-grow-1">
                <label for="status" class="form-label mb-2">{{ __('cms.order_details.update_order_status') }}</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ __('cms.order_details.order_statuses.pending') }}</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ __('cms.order_details.order_statuses.processing') }}</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>{{ __('cms.order_details.order_statuses.completed') }}</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ __('cms.order_details.order_statuses.cancelled') }}</option>
                </select>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>{{ __('cms.order_details.update_status') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('cms.messages.success') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", "{{ __('cms.product_reviews.error') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif
@endsection
