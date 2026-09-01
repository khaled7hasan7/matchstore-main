@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .coupon-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #0066cc;
            background: #e7f3ff;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
        }

        .discount-badge {
            background: #d1e7dd;
            color: #0a3622;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .type-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-badge.percentage {
            background: #cfe2ff;
            color: #084298;
        }

        .type-badge.fixed {
            background: #d1e7dd;
            color: #0a3622;
        }

        .expiry-date {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.coupons.heading') }}</h2>
                <p class="page-subtitle">{{ __('cms.coupons.subtitle') ?? 'Manage discount coupons' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.coupons.create') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Coupons Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="coupons-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.coupons.id') }}</th>
                            <th>{{ __('cms.coupons.code') }}</th>
                            <th style="width: 120px;">{{ __('cms.coupons.discount') }}</th>
                            <th class="text-center" style="width: 120px;">{{ __('cms.coupons.type') }}</th>
                            <th style="width: 150px;">{{ __('cms.coupons.expires_at') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.coupons.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.coupons.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td><span class="coupon-code">{{ $coupon->code }}</span></td>
                                <td>
                                    <span class="discount-badge">
                                        @if($coupon->type === 'percentage')
                                            {{ $coupon->discount }}%
                                        @else
                                            {{ order_amount($coupon->discount) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="type-badge {{ $coupon->type }}">
                                        {{ ucfirst($coupon->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($coupon->expires_at)
                                        <span class="expiry-date">{{ \Carbon\Carbon::parse($coupon->expires_at)->format('M d, Y') }}</span>
                                    @else
                                        <span class="text-muted">{{ __('cms.coupons.no_expiry') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($coupon->isExpired())
                                        <span class="status-badge inactive">{{ __('cms.coupons.expired') }}</span>
                                    @else
                                        <span class="status-badge active">{{ __('cms.coupons.active') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-btns">
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="action-btn edit-btn" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <span class="action-btn delete-btn" onclick="deleteCoupon({{ $coupon->id }})" title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">{{ __('cms.coupons.no_coupons') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.coupons.massage_confirm') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ __('cms.coupons.confirm_delete') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('cms.coupons.massage_cancel') }}
                </button>
                <form id="deleteCouponForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>{{ __('cms.coupons.massage_delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('cms.coupons.success') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

<script>
    function deleteCoupon(couponId) {
        const deleteForm = document.getElementById('deleteCouponForm');
        deleteForm.action = `/admin/coupons/${couponId}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteCouponModal'));
        modal.show();
    }
</script>
@endsection
