@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.coupons.create') }}</h2>
                <p class="page-subtitle">{{ __('cms.coupons.create_subtitle') ?? 'Create a new discount coupon' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.coupons.back') ?? 'Back' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="code" class="form-label">{{ __('cms.coupons.code') }} <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('code') is-invalid @enderror"
                               id="code"
                               name="code"
                               value="{{ old('code') }}"
                               placeholder="e.g., SUMMER2024"
                               required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('cms.coupons.code_help') }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ __('cms.coupons.type') }} <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type"
                                name="type"
                                required
                                onchange="updateDiscountLabel()">
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                {{ __('cms.coupons.percentage') }}
                            </option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                {{ __('cms.coupons.fixed') }}
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="discount" class="form-label">
                            <span id="discount-label">{{ __('cms.coupons.discount') }}</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               class="form-control @error('discount') is-invalid @enderror"
                               id="discount"
                               name="discount"
                               value="{{ old('discount') }}"
                               step="0.01"
                               min="0"
                               required>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted" id="discount-help">{{ __('cms.coupons.discount_help_percentage') }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="expires_at" class="form-label">{{ __('cms.coupons.expires_at') }}</label>
                        <input type="datetime-local"
                               class="form-control @error('expires_at') is-invalid @enderror"
                               id="expires_at"
                               name="expires_at"
                               value="{{ old('expires_at') }}">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('cms.coupons.expires_help') }}</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>{{ __('cms.coupons.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.coupons.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function updateDiscountLabel() {
        const type = document.getElementById('type').value;
        const discountLabel = document.getElementById('discount-label');
        const discountHelp = document.getElementById('discount-help');

        if (type === 'percentage') {
            discountLabel.textContent = '{{ __('cms.coupons.discount_percentage') }}';
            discountHelp.textContent = '{{ __('cms.coupons.discount_help_percentage') }}';
        } else {
            discountLabel.textContent = '{{ __('cms.coupons.discount_amount') }}';
            discountHelp.textContent = '{{ __('cms.coupons.discount_help_fixed') }}';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', updateDiscountLabel);
</script>
@endsection
