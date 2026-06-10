@extends('admin.layouts.admin')

@section('title', __('cms.shipping_zones.create_title') ?? 'Create Shipping Zone')

@section('css')
    <style>
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }

        .form-label {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            padding: 0.625rem 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .text-muted {
            font-size: 0.875rem;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-top: 0.125rem;
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            margin-left: 0.5rem;
        }

        .btn-primary {
            padding: 0.625rem 1.5rem;
            font-weight: 500;
        }

        .section-divider {
            margin: 2rem 0;
            border-top: 1px solid #e9ecef;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.shipping_zones.create_title') ?? 'Create Shipping Zone' }}</h2>
                <p class="page-subtitle">{{ __('cms.shipping_zones.create_subtitle') ?? 'Add a new shipping zone with rates' }}</p>
            </div>
            <div>
                <a href="{{ route('shipping-zones.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.shipping_zones.back_to_list') ?? 'Back to List' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading mb-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ __('cms.shipping_zones.validation_error') ?? 'Please correct the following errors:' }}
                    </h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('shipping-zones.store') }}" method="POST">
                @csrf

                {{-- Zone Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label">
                        {{ __('cms.shipping_zones.name') ?? 'Zone Name' }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="E.g., Jordan, Palestine, Other Countries"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">{{ __('cms.shipping_zones.name_help') ?? 'Enter a descriptive name for this shipping zone' }}</small>
                </div>

                {{-- Countries --}}
                <div class="mb-4">
                    <label for="countries" class="form-label">
                        {{ __('cms.shipping_zones.countries') ?? 'Countries' }}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('countries') is-invalid @enderror"
                            id="countries"
                            name="countries[]"
                            multiple
                            required
                            size="10">
                        <option value="*">{{ __('cms.shipping_zones.all_countries') ?? 'All Countries (*)' }}</option>
                        <option value="JO">Jordan (JO)</option>
                        <option value="PS">Palestine (PS)</option>
                        <option value="IL">Israel (IL)</option>
                        <option value="SA">Saudi Arabia (SA)</option>
                        <option value="AE">UAE (AE)</option>
                        <option value="EG">Egypt (EG)</option>
                        <option value="LB">Lebanon (LB)</option>
                        <option value="SY">Syria (SY)</option>
                        <option value="IQ">Iraq (IQ)</option>
                        <option value="KW">Kuwait (KW)</option>
                        <option value="QA">Qatar (QA)</option>
                        <option value="BH">Bahrain (BH)</option>
                        <option value="OM">Oman (OM)</option>
                        <option value="US">United States (US)</option>
                        <option value="GB">United Kingdom (GB)</option>
                        <option value="DE">Germany (DE)</option>
                        <option value="FR">France (FR)</option>
                        <option value="IT">Italy (IT)</option>
                        <option value="ES">Spain (ES)</option>
                    </select>
                    @error('countries')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">{{ __('cms.shipping_zones.countries_help') ?? 'Hold Ctrl (Windows) or Cmd (Mac) to select multiple countries' }}</small>
                </div>

                <div class="section-divider"></div>

                {{-- Shipping Costs --}}
                <h5 class="mb-3">{{ __('cms.shipping_zones.shipping_costs') ?? 'Shipping Costs' }}</h5>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="base_cost" class="form-label">
                            {{ __('cms.shipping_zones.base_cost') ?? 'Base Cost ($)' }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               step="0.01"
                               class="form-control @error('base_cost') is-invalid @enderror"
                               id="base_cost"
                               name="base_cost"
                               value="{{ old('base_cost', 0) }}"
                               placeholder="0.00"
                               required
                               min="0">
                        @error('base_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('cms.shipping_zones.base_cost_help') ?? 'Flat shipping rate' }}</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="per_kg_cost" class="form-label">
                            {{ __('cms.shipping_zones.per_kg_cost') ?? 'Per KG Cost ($)' }}
                        </label>
                        <input type="number"
                               step="0.01"
                               class="form-control @error('per_kg_cost') is-invalid @enderror"
                               id="per_kg_cost"
                               name="per_kg_cost"
                               value="{{ old('per_kg_cost', 0) }}"
                               placeholder="0.00"
                               min="0">
                        @error('per_kg_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('cms.shipping_zones.per_kg_cost_help') ?? 'Additional cost per kilogram' }}</small>
                    </div>
                </div>

                <div class="section-divider"></div>

                {{-- Status --}}
                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            {{ __('cms.shipping_zones.is_active') ?? 'Active' }}
                        </label>
                    </div>
                    <small class="text-muted">{{ __('cms.shipping_zones.is_active_help') ?? 'Enable this shipping zone for customers' }}</small>
                </div>

                {{-- Submit Button --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('shipping-zones.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>{{ __('cms.shipping_zones.cancel') ?? 'Cancel' }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.shipping_zones.create_button') ?? 'Create Shipping Zone' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
