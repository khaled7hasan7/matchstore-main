@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.payment_gateways.edit_title') }}</h2>
                <p class="page-subtitle">{{ __('cms.payment_gateways.edit_subtitle') ?? 'Update payment gateway settings' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.payment_gateways.back') ?? 'Back' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card">
        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-start mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                    <div>
                        <strong>{{ __('cms.errors.whoops') }}</strong> {{ __('cms.errors.input_problem') }}
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Edit Form --}}
            <form action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Gateway Info Section --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('cms.payment_gateways.gateway_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $paymentGateway->name) }}"
                               class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="code" class="form-label">{{ __('cms.payment_gateways.code') }} <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code', $paymentGateway->code) }}"
                               class="form-control @error('code') is-invalid @enderror" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('cms.payment_gateways.unique') }}</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('cms.payment_gateways.description') }}</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $paymentGateway->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                           {{ $paymentGateway->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('cms.payment_gateways.active_label') }}</label>
                </div>

                <hr class="my-4">

                {{-- Configurations Section --}}
                <h5 class="mb-3"><i class="bi bi-gear-fill me-2"></i>{{ __('cms.payment_gateways.configurations') }}</h5>
                @forelse ($paymentGateway->configs as $config)
                    <div class="card mb-3">
                        <div class="card-body">
                            <input type="hidden" name="configs[{{ $config->id }}][id]" value="{{ $config->id }}">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('cms.payment_gateways.key_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="configs[{{ $config->id }}][key_name]"
                                           value="{{ old("configs.$config->id.key_name", $config->key_name) }}"
                                           class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('cms.payment_gateways.key_value') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="configs[{{ $config->id }}][key_value]"
                                           value="{{ old("configs.$config->id.key_value", $config->key_value) }}"
                                           class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('cms.payment_gateways.environment') }}</label>
                                    <select name="configs[{{ $config->id }}][environment]" class="form-select">
                                        <option value="sandbox" {{ $config->environment === 'sandbox' ? 'selected' : '' }}>
                                            {{ __('cms.payment_gateways.sandbox') }}
                                        </option>
                                        <option value="production" {{ $config->environment === 'production' ? 'selected' : '' }}>
                                            {{ __('cms.payment_gateways.production') }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-check">
                                        <input type="hidden" name="configs[{{ $config->id }}][is_encrypted]" value="0">
                                        <input type="checkbox" class="form-check-input"
                                               name="configs[{{ $config->id }}][is_encrypted]" value="1"
                                               id="encrypted_{{ $config->id }}"
                                               {{ $config->is_encrypted ? 'checked' : '' }}>
                                        <label class="form-check-label" for="encrypted_{{ $config->id }}">
                                            {{ __('cms.payment_gateways.encrypted') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        {{ __('cms.payment_gateways.no_configurations') }}
                    </div>
                @endforelse

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>{{ __('cms.payment_gateways.cancel') ?? 'Cancel' }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.payment_gateways.update_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
