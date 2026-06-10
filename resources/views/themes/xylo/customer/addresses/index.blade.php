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
   Mobile Addresses Styles
   ================================ */

/* Mobile Addresses Header */
.mobile-addresses-header {
    background: #fff;
    padding: 16px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.mobile-addresses-header h1 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #212529;
}

.mobile-add-btn {
    background: {{ config('store.primary_color', '#0e0e0e') }};
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

/* Mobile Addresses Content */
.mobile-addresses-content {
    padding: 16px;
    padding-bottom: 80px;
    background: #f8f9fa;
}

/* Mobile Empty State */
.mobile-empty-addresses {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 16px;
}

.mobile-empty-addresses i {
    font-size: 60px;
    color: #dee2e6;
    margin-bottom: 16px;
}

.mobile-empty-addresses h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.mobile-empty-addresses p {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 20px;
}

.mobile-empty-addresses a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--main-color);
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
}

/* Mobile Address Card */
.mobile-address-card {
    background: #fff;
    border-radius: 14px;
    margin-bottom: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

.mobile-address-card.is-default {
    border: 2px solid var(--main-color);
}

.mobile-address-header {
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-address-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: #212529;
}

.mobile-address-label i {
    color: var(--main-color);
    font-size: 14px;
}

.mobile-default-badge {
    background: #28a745;
    color: white;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
}

.mobile-address-body {
    padding: 14px 16px;
}

.mobile-address-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.mobile-address-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: #495057;
}

.mobile-address-row i {
    color: #6c757d;
    width: 16px;
    margin-top: 2px;
}

.mobile-address-row strong {
    color: #212529;
}

.mobile-address-extra {
    font-size: 12px;
    color: #6c757d;
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 8px;
    margin-top: 8px;
}

.mobile-address-actions {
    display: flex;
    gap: 8px;
    padding: 12px 16px;
    border-top: 1px solid #eee;
    background: #fafafa;
}

.mobile-address-action {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
}

.mobile-action-edit {
    background: #f8f9fa;
    color: {{ config('store.primary_color', '#0e0e0e') }};
    border: 1px solid #dee2e6;
}

.mobile-action-default {
    background: #d4edda;
    color: #155724;
}

.mobile-action-delete {
    background: #fff5f5;
    color: #dc3545;
    width: 44px;
    flex: 0 0 44px;
}

/* Mobile Back Link */
.mobile-back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 16px;
    color: #6c757d;
    text-decoration: none;
    font-size: 14px;
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-addresses-header {
        padding: 14px 12px;
    }

    .mobile-addresses-header h1 {
        font-size: 16px;
    }

    .mobile-add-btn {
        padding: 8px 14px;
        font-size: 13px;
    }

    .mobile-addresses-content {
        padding: 12px;
    }

    .mobile-address-card {
        border-radius: 12px;
    }

    .mobile-address-header {
        padding: 12px 14px;
    }

    .mobile-address-label {
        font-size: 14px;
    }

    .mobile-address-body {
        padding: 12px 14px;
    }

    .mobile-address-row {
        font-size: 12px;
    }

    .mobile-address-actions {
        gap: 6px;
        padding: 10px 14px;
    }

    .mobile-address-action {
        padding: 8px;
        font-size: 12px;
    }
}
</style>
@endsection

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">

            {{-- Page Header --}}
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">{{ __('store.addresses.title') }}</h2>
                    <p class="text-muted">{{ __('store.addresses.subtitle') }}</p>
                </div>
                <a href="{{ route('customer.addresses.create') }}" class="btn btn-dark">
                    <i class="fas fa-plus me-2"></i>{{ __('store.addresses.add_new') }}
                </a>
            </div>

            {{-- Addresses List --}}
            @if($addresses->isEmpty())
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-map-marker-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('store.addresses.no_addresses') }}</h4>
                        <p class="text-muted">{{ __('store.addresses.no_addresses_desc') }}</p>
                        <a href="{{ route('customer.addresses.create') }}" class="btn btn-dark mt-3">
                            <i class="fas fa-plus me-2"></i>{{ __('store.addresses.add_first_address') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($addresses as $address)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100 address-card {{ $address->is_default ? 'default-address' : '' }}">
                                <div class="card-body p-4">
                                    {{-- Header with Label and Default Badge --}}
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            @if($address->label)
                                                <h5 class="fw-semibold mb-1">
                                                    <i class="fas fa-tag me-2" style="color: {{ config('store.accent_color', '#ffc107') }};"></i>
                                                    {{ $address->label }}
                                                </h5>
                                            @else
                                                <h5 class="fw-semibold mb-1">
                                                    <i class="fas fa-map-marker-alt me-2" style="color: {{ config('store.accent_color', '#ffc107') }};"></i>
                                                    {{ __('store.addresses.address') }}
                                                </h5>
                                            @endif
                                            @if($address->is_default)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>{{ __('store.addresses.default') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Address Details --}}
                                    <div class="address-details">
                                        <p class="mb-2"><strong><i class="fas fa-user me-2 text-muted"></i>{{ $address->full_name }}</strong></p>
                                        <p class="mb-2 text-muted"><i class="fas fa-phone me-2"></i>{{ $address->phone }}</p>
                                        <p class="mb-2 text-muted">
                                            <i class="fas fa-location-dot me-2"></i>{{ $address->street_address }}
                                        </p>
                                        <p class="mb-2 text-muted">
                                            <i class="fas fa-city me-2"></i>
                                            {{ $address->city }}@if($address->state), {{ $address->state }}@endif {{ $address->postal_code }}
                                        </p>
                                        <p class="mb-2 text-muted">
                                            <i class="fas fa-flag me-2"></i>{{ $address->country }}
                                        </p>
                                        @if($address->additional_info)
                                            <p class="mb-0 text-muted small">
                                                <i class="fas fa-info-circle me-2"></i>{{ $address->additional_info }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="mt-4 pt-3 border-top d-flex gap-2">
                                        <a href="{{ route('customer.addresses.edit', $address->id) }}" class="btn btn-outline-dark btn-sm flex-fill">
                                            <i class="fas fa-edit me-1"></i>{{ __('store.addresses.edit') }}
                                        </a>

                                        @if(!$address->is_default)
                                            <form action="{{ route('customer.addresses.setDefault', $address->id) }}" method="POST" class="flex-fill">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                                    <i class="fas fa-check me-1"></i>{{ __('store.addresses.set_default') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('customer.addresses.destroy', $address->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Back to Profile Link --}}
            <div class="mt-4 text-center">
                <a href="{{ route('customer.profile.edit') }}" class="text-muted">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('store.addresses.back_to_profile') }}
                </a>
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

    {{-- Mobile Addresses Header --}}
    <div class="mobile-addresses-header">
        <h1>{{ __('store.addresses.title') }}</h1>
        <a href="{{ route('customer.addresses.create') }}" class="mobile-add-btn">
            <i class="fas fa-plus"></i>
            {{ __('store.addresses.add_new') }}
        </a>
    </div>

    {{-- Mobile Addresses Content --}}
    <div class="mobile-addresses-content">

        @if($addresses->isEmpty())
            {{-- Mobile Empty State --}}
            <div class="mobile-empty-addresses">
                <i class="fas fa-map-marker-alt"></i>
                <h2>{{ __('store.addresses.no_addresses') }}</h2>
                <p>{{ __('store.addresses.no_addresses_desc') }}</p>
                <a href="{{ route('customer.addresses.create') }}">
                    <i class="fas fa-plus"></i>
                    {{ __('store.addresses.add_first_address') }}
                </a>
            </div>
        @else
            {{-- Mobile Address Cards --}}
            @foreach($addresses as $address)
                <div class="mobile-address-card {{ $address->is_default ? 'is-default' : '' }}">
                    <div class="mobile-address-header">
                        <div class="mobile-address-label">
                            @if($address->label)
                                <i class="fas fa-tag"></i>
                                {{ $address->label }}
                            @else
                                <i class="fas fa-map-marker-alt"></i>
                                {{ __('store.addresses.address') }}
                            @endif
                        </div>
                        @if($address->is_default)
                            <span class="mobile-default-badge">
                                <i class="fas fa-check"></i> {{ __('store.addresses.default') }}
                            </span>
                        @endif
                    </div>

                    <div class="mobile-address-body">
                        <div class="mobile-address-info">
                            <div class="mobile-address-row">
                                <i class="fas fa-user"></i>
                                <strong>{{ $address->full_name }}</strong>
                            </div>
                            <div class="mobile-address-row">
                                <i class="fas fa-phone"></i>
                                <span>{{ $address->phone }}</span>
                            </div>
                            <div class="mobile-address-row">
                                <i class="fas fa-location-dot"></i>
                                <span>{{ $address->street_address }}</span>
                            </div>
                            <div class="mobile-address-row">
                                <i class="fas fa-city"></i>
                                <span>{{ $address->city }}@if($address->state), {{ $address->state }}@endif {{ $address->postal_code }}</span>
                            </div>
                            <div class="mobile-address-row">
                                <i class="fas fa-flag"></i>
                                <span>{{ $address->country }}</span>
                            </div>
                        </div>
                        @if($address->additional_info)
                            <div class="mobile-address-extra">
                                <i class="fas fa-info-circle"></i> {{ $address->additional_info }}
                            </div>
                        @endif
                    </div>

                    <div class="mobile-address-actions">
                        <a href="{{ route('customer.addresses.edit', $address->id) }}" class="mobile-address-action mobile-action-edit">
                            <i class="fas fa-edit"></i>
                            {{ __('store.addresses.edit') }}
                        </a>

                        @if(!$address->is_default)
                            <form action="{{ route('customer.addresses.setDefault', $address->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="mobile-address-action mobile-action-default" style="width: 100%;">
                                    <i class="fas fa-check"></i>
                                    {{ __('store.addresses.set_default') }}
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('customer.addresses.destroy', $address->id) }}" method="POST" class="mobile-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mobile-address-action mobile-action-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Mobile Back Link --}}
        <a href="{{ route('customer.profile.edit') }}" class="mobile-back-link">
            <i class="fas fa-arrow-left"></i>
            {{ __('store.addresses.back_to_profile') }}
        </a>

    </div>

</div>
{{-- END MOBILE VERSION --}}

<style>
    .address-card {
        transition: all 0.3s ease;
        position: relative;
    }

    .address-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
    }

    .default-address {
        border: 2px solid {{ config('store.accent_color', '#ffc107') }};
    }

    .address-details {
        font-size: 0.95rem;
    }

    .address-details i {
        width: 20px;
    }

    .btn-dark {
        background-color: {{ config('store.primary_color', '#0e0e0e') }};
        border-color: {{ config('store.primary_color', '#0e0e0e') }};
    }

    .btn-dark:hover {
        opacity: 0.9;
    }

    .btn-outline-dark {
        color: {{ config('store.primary_color', '#0e0e0e') }};
        border-color: {{ config('store.primary_color', '#0e0e0e') }};
    }

    .btn-outline-dark:hover {
        background-color: {{ config('store.primary_color', '#0e0e0e') }};
        border-color: {{ config('store.primary_color', '#0e0e0e') }};
        color: white;
    }
</style>
@endsection

@section('js')
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('general.success') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

{{-- Delete Confirmation Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Desktop delete forms
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('{{ __('store.addresses.delete_confirm') }}')) {
                e.preventDefault();
            }
        });
    });

    // Mobile delete forms
    const mobileDeleteForms = document.querySelectorAll('.mobile-delete-form');
    mobileDeleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('{{ __('store.addresses.delete_confirm') }}')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection
