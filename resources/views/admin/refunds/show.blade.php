@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.refunds.details_title') }}</h2>
                <p class="page-subtitle">{{ __('cms.refunds.details_subtitle') ?? 'View refund request details' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.refunds.back') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Refund Details Card --}}
    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.id') }}</h6>
                    <p class="mb-0 fw-semibold">#{{ $refund->id }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.payment') }}</h6>
                    <p class="mb-0 fw-semibold">
                        @if($refund->payment)
                            {{ __('cms.refunds.payment') }} #{{ $refund->payment->id }}
                            <span class="text-muted">({{ __('cms.refunds.amount') }}: ${{ $refund->payment->amount }})</span>
                        @else
                            {{ __('cms.refunds.not_available') }}
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.amount') }}</h6>
                    <p class="mb-0">
                        <span class="badge" style="background: #e7f3ff; color: #0066cc; font-size: 1rem; font-weight: 600;">${{ $refund->amount }}</span>
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.status') }}</h6>
                    <div>
                        @if($refund->status === 'approved')
                            <span class="status-badge active">Approved</span>
                        @elseif($refund->status === 'rejected')
                            <span class="status-badge inactive">Rejected</span>
                        @else
                            <span class="status-badge" style="background: #fff3cd; color: #856404;">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.reason') }}</h6>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">{{ $refund->reason ?? __('cms.refunds.not_available') }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.created_at') }}</h6>
                    <p class="mb-0 fw-semibold">{{ $refund->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted mb-2">{{ __('cms.refunds.updated_at') }}</h6>
                    <p class="mb-0 fw-semibold">{{ $refund->updated_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.refunds.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection