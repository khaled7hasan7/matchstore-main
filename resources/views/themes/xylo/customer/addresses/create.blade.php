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
   Mobile Address Form Styles
   ================================ */

/* Mobile Form Header */
.mobile-address-form-header {
    background: #fff;
    padding: 16px;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 12px;
}

.mobile-form-back {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 10px;
    color: #212529;
    text-decoration: none;
}

.mobile-address-form-header h1 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #212529;
}

/* Mobile Form Content */
.mobile-address-form-content {
    padding: 16px;
    padding-bottom: 100px;
    background: #f8f9fa;
}

.mobile-form-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Mobile Form Elements */
.mobile-form-group {
    margin-bottom: 18px;
}

.mobile-form-group:last-child {
    margin-bottom: 0;
}

.mobile-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 6px;
}

.mobile-form-label .required {
    color: #dc3545;
}

.mobile-form-label .optional {
    color: #6c757d;
    font-weight: 400;
    font-size: 12px;
}

.mobile-form-input {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.mobile-form-input:focus {
    outline: none;
    border-color: var(--main-color);
}

.mobile-form-input.is-invalid {
    border-color: #dc3545;
}

.mobile-form-textarea {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    font-size: 14px;
    resize: vertical;
    min-height: 80px;
}

.mobile-form-textarea:focus {
    outline: none;
    border-color: var(--main-color);
}

.mobile-invalid-feedback {
    font-size: 12px;
    color: #dc3545;
    margin-top: 4px;
}

.mobile-form-hint {
    font-size: 11px;
    color: #6c757d;
    margin-top: 4px;
}

/* Mobile Two Column Row */
.mobile-form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

/* Mobile Checkbox */
.mobile-checkbox-group {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 18px;
}

.mobile-checkbox-group input[type="checkbox"] {
    width: 22px;
    height: 22px;
    accent-color: var(--main-color);
    margin-top: 2px;
    flex-shrink: 0;
}

.mobile-checkbox-label {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 2px;
}

.mobile-checkbox-hint {
    font-size: 12px;
    color: #6c757d;
}

/* Mobile Form Actions */
.mobile-form-actions {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    padding: 16px;
    display: flex;
    gap: 12px;
    border-top: 1px solid #eee;
    z-index: 100;
}

.mobile-form-submit {
    flex: 1;
    background: {{ config('store.primary_color', '#0e0e0e') }};
    color: white;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.mobile-form-cancel {
    background: #f8f9fa;
    color: #6c757d;
    border: none;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-address-form-header {
        padding: 14px 12px;
    }

    .mobile-address-form-header h1 {
        font-size: 16px;
    }

    .mobile-address-form-content {
        padding: 12px;
        padding-bottom: 90px;
    }

    .mobile-form-card {
        padding: 16px;
        border-radius: 14px;
    }

    .mobile-form-input,
    .mobile-form-textarea {
        padding: 12px 14px;
        font-size: 14px;
    }

    .mobile-form-row {
        grid-template-columns: 1fr;
    }

    .mobile-form-actions {
        padding: 12px;
    }

    .mobile-form-submit,
    .mobile-form-cancel {
        padding: 12px;
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
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            {{-- Page Header --}}
            <div class="mb-4">
                <h2 class="fw-bold">{{ __('store.addresses.add_new') }}</h2>
                <p class="text-muted">{{ __('store.addresses.add_subtitle') }}</p>
            </div>

            {{-- Address Form Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('customer.addresses.store') }}" method="POST" id="addressForm">
                        @csrf

                        {{-- Label Field --}}
                        <div class="mb-4">
                            <label for="label" class="form-label fw-semibold">
                                {{ __('store.addresses.label') }}
                                <span class="text-muted small">({{ __('general.optional') }})</span>
                            </label>
                            <input type="text"
                                   name="label"
                                   id="label"
                                   value="{{ old('label') }}"
                                   class="form-control @error('label') is-invalid @enderror"
                                   placeholder="{{ __('store.addresses.label_placeholder') }}">
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('store.addresses.label_help') }}</small>
                        </div>

                        {{-- Full Name Field --}}
                        <div class="mb-4">
                            <label for="full_name" class="form-label fw-semibold">
                                {{ __('store.addresses.full_name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="full_name"
                                   id="full_name"
                                   value="{{ old('full_name', auth('customer')->user()->name) }}"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone Field --}}
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-semibold">
                                {{ __('store.addresses.phone') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', auth('customer')->user()->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Street Address Field --}}
                        <div class="mb-4">
                            <label for="street_address" class="form-label fw-semibold">
                                {{ __('store.addresses.street_address') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="street_address"
                                   id="street_address"
                                   value="{{ old('street_address') }}"
                                   class="form-control @error('street_address') is-invalid @enderror"
                                   placeholder="{{ __('store.addresses.street_placeholder') }}"
                                   required>
                            @error('street_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- City and State Row --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="city" class="form-label fw-semibold">
                                    {{ __('store.addresses.city') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="city"
                                       id="city"
                                       value="{{ old('city') }}"
                                       class="form-control @error('city') is-invalid @enderror"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="state" class="form-label fw-semibold">
                                    {{ __('store.addresses.state') }}
                                    <span class="text-muted small">({{ __('general.optional') }})</span>
                                </label>
                                <input type="text"
                                       name="state"
                                       id="state"
                                       value="{{ old('state') }}"
                                       class="form-control @error('state') is-invalid @enderror">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Postal Code and Country Row --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="postal_code" class="form-label fw-semibold">
                                    {{ __('store.addresses.postal_code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="postal_code"
                                       id="postal_code"
                                       value="{{ old('postal_code') }}"
                                       class="form-control @error('postal_code') is-invalid @enderror"
                                       required>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="country" class="form-label fw-semibold">
                                    {{ __('store.addresses.country') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="country"
                                       id="country"
                                       value="{{ old('country') }}"
                                       class="form-control @error('country') is-invalid @enderror"
                                       required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Additional Info Field --}}
                        <div class="mb-4">
                            <label for="additional_info" class="form-label fw-semibold">
                                {{ __('store.addresses.additional_info') }}
                                <span class="text-muted small">({{ __('general.optional') }})</span>
                            </label>
                            <textarea name="additional_info"
                                      id="additional_info"
                                      rows="3"
                                      class="form-control @error('additional_info') is-invalid @enderror"
                                      placeholder="{{ __('store.addresses.additional_info_placeholder') }}">{{ old('additional_info') }}</textarea>
                            @error('additional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('store.addresses.additional_info_help') }}</small>
                        </div>

                        {{-- Set as Default Checkbox --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_default"
                                       id="is_default"
                                       value="1"
                                       {{ old('is_default') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_default">
                                    {{ __('store.addresses.set_as_default') }}
                                </label>
                            </div>
                            <small class="text-muted">{{ __('store.addresses.default_help') }}</small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-dark btn-lg flex-fill">
                                <i class="fas fa-save me-2"></i>{{ __('store.addresses.save_address') }}
                            </button>
                            <a href="{{ route('customer.addresses.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>{{ __('general.cancel') }}
                            </a>
                        </div>
                    </form>
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

    {{-- Mobile Form Header --}}
    <div class="mobile-address-form-header">
        <a href="{{ route('customer.addresses.index') }}" class="mobile-form-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ __('store.addresses.add_new') }}</h1>
    </div>

    {{-- Mobile Form Content --}}
    <div class="mobile-address-form-content">
        <div class="mobile-form-card">
            <form action="{{ route('customer.addresses.store') }}" method="POST" id="mobileAddressForm">
                @csrf

                {{-- Label Field --}}
                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.addresses.label') }}
                        <span class="optional">({{ __('general.optional') }})</span>
                    </label>
                    <input type="text"
                           name="label"
                           value="{{ old('label') }}"
                           class="mobile-form-input @error('label') is-invalid @enderror"
                           placeholder="{{ __('store.addresses.label_placeholder') }}">
                    @error('label')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mobile-form-hint">{{ __('store.addresses.label_help') }}</div>
                </div>

                {{-- Full Name Field --}}
                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.addresses.full_name') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text"
                           name="full_name"
                           value="{{ old('full_name', auth('customer')->user()->name) }}"
                           class="mobile-form-input @error('full_name') is-invalid @enderror"
                           required>
                    @error('full_name')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone Field --}}
                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.addresses.phone') }}
                        <span class="required">*</span>
                    </label>
                    <input type="tel"
                           name="phone"
                           value="{{ old('phone', auth('customer')->user()->phone) }}"
                           class="mobile-form-input @error('phone') is-invalid @enderror"
                           required>
                    @error('phone')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Street Address Field --}}
                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.addresses.street_address') }}
                        <span class="required">*</span>
                    </label>
                    <input type="text"
                           name="street_address"
                           value="{{ old('street_address') }}"
                           class="mobile-form-input @error('street_address') is-invalid @enderror"
                           placeholder="{{ __('store.addresses.street_placeholder') }}"
                           required>
                    @error('street_address')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- City and State Row --}}
                <div class="mobile-form-row">
                    <div class="mobile-form-group">
                        <label class="mobile-form-label">
                            {{ __('store.addresses.city') }}
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="city"
                               value="{{ old('city') }}"
                               class="mobile-form-input @error('city') is-invalid @enderror"
                               required>
                        @error('city')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">
                            {{ __('store.addresses.state') }}
                            <span class="optional">({{ __('general.optional') }})</span>
                        </label>
                        <input type="text"
                               name="state"
                               value="{{ old('state') }}"
                               class="mobile-form-input @error('state') is-invalid @enderror">
                        @error('state')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Postal Code and Country Row --}}
                <div class="mobile-form-row">
                    <div class="mobile-form-group">
                        <label class="mobile-form-label">
                            {{ __('store.addresses.postal_code') }}
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="postal_code"
                               value="{{ old('postal_code') }}"
                               class="mobile-form-input @error('postal_code') is-invalid @enderror"
                               required>
                        @error('postal_code')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">
                            {{ __('store.addresses.country') }}
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="country"
                               value="{{ old('country') }}"
                               class="mobile-form-input @error('country') is-invalid @enderror"
                               required>
                        @error('country')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Additional Info Field --}}
                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.addresses.additional_info') }}
                        <span class="optional">({{ __('general.optional') }})</span>
                    </label>
                    <textarea name="additional_info"
                              rows="3"
                              class="mobile-form-textarea @error('additional_info') is-invalid @enderror"
                              placeholder="{{ __('store.addresses.additional_info_placeholder') }}">{{ old('additional_info') }}</textarea>
                    @error('additional_info')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Set as Default Checkbox --}}
                <div class="mobile-checkbox-group">
                    <input type="checkbox"
                           name="is_default"
                           id="mobile_is_default"
                           value="1"
                           {{ old('is_default') ? 'checked' : '' }}>
                    <div>
                        <div class="mobile-checkbox-label">{{ __('store.addresses.set_as_default') }}</div>
                        <div class="mobile-checkbox-hint">{{ __('store.addresses.default_help') }}</div>
                    </div>
                </div>

                {{-- Mobile Form Actions (Fixed at bottom) --}}
                <div class="mobile-form-actions">
                    <a href="{{ route('customer.addresses.index') }}" class="mobile-form-cancel">
                        {{ __('general.cancel') }}
                    </a>
                    <button type="submit" class="mobile-form-submit">
                        <i class="fas fa-save"></i>
                        {{ __('store.addresses.save_address') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
{{-- END MOBILE VERSION --}}

<style>
    .form-control:focus {
        border-color: {{ config('store.accent_color', '#ffc107') }};
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .form-check-input:checked {
        background-color: {{ config('store.accent_color', '#ffc107') }};
        border-color: {{ config('store.accent_color', '#ffc107') }};
    }

    .btn-dark {
        background-color: {{ config('store.primary_color', '#0e0e0e') }};
        border-color: {{ config('store.primary_color', '#0e0e0e') }};
    }

    .btn-dark:hover {
        opacity: 0.9;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('js')
@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", "{{ __('general.error') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif
@endsection
