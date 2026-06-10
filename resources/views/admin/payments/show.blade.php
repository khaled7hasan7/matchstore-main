@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.payments.details_title') }}</h2>
                <p class="page-subtitle">{{ __('cms.payments.details_subtitle') ?? 'View payment transaction details' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.payments.back') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Payment Details Card --}}
    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.id') }}</h6>
                    <p class="mb-0 fw-semibold">#{{ $payment->id }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.user') }}</h6>
                    <p class="mb-0 fw-semibold">{{ $payment->user->name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.order') }}</h6>
                    <p class="mb-0 fw-semibold">#{{ $payment->order->id ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.gateway') }}</h6>
                    <p class="mb-0 fw-semibold">{{ $payment->gateway->name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.amount') }}</h6>
                    <p class="mb-0">
                        <span class="badge" style="background: #e7f3ff; color: #0066cc; font-size: 1rem; font-weight: 600;">${{ number_format($payment->amount, 2) }}</span>
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.status') }}</h6>
                    <div>
                        @if($payment->status === 'completed' || $payment->status === 'paid')
                            <span class="status-badge active">Paid</span>
                        @elseif($payment->status === 'failed')
                            <span class="status-badge inactive">Failed</span>
                        @else
                            <span class="status-badge" style="background: #fff3cd; color: #856404;">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.transaction_id') }}</h6>
                    <p class="mb-0" style="font-family: 'Courier New', monospace; font-weight: 600; color: #6c757d;">
                        {{ $payment->transaction_id ?? 'N/A' }}
                    </p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted mb-2">{{ __('cms.payments.created_at') }}</h6>
                    <p class="mb-0 fw-semibold">{{ $payment->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.payments.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection