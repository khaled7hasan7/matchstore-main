@extends('admin.layouts.admin')

@section('title', 'Edit Shipping Zone')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2>Edit Shipping Zone</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('shipping-zones.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('shipping-zones.update', $shippingZone->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Zone Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $shippingZone->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">E.g., "Jordan", "Palestine", "Other Countries"</small>
                </div>

                <div class="mb-3">
                    <label for="countries" class="form-label">Countries <span class="text-danger">*</span></label>
                    <select class="form-select" id="countries" name="countries[]" multiple required>
                        <option value="*" {{ in_array('*', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>All Countries (*)</option>
                        <option value="JO" {{ in_array('JO', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Jordan (JO)</option>
                        <option value="PS" {{ in_array('PS', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Palestine (PS)</option>
                        <option value="IL" {{ in_array('IL', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Israel (IL)</option>
                        <option value="SA" {{ in_array('SA', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Saudi Arabia (SA)</option>
                        <option value="AE" {{ in_array('AE', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>UAE (AE)</option>
                        <option value="EG" {{ in_array('EG', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Egypt (EG)</option>
                        <option value="LB" {{ in_array('LB', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Lebanon (LB)</option>
                        <option value="SY" {{ in_array('SY', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Syria (SY)</option>
                        <option value="IQ" {{ in_array('IQ', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Iraq (IQ)</option>
                        <option value="KW" {{ in_array('KW', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Kuwait (KW)</option>
                        <option value="QA" {{ in_array('QA', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Qatar (QA)</option>
                        <option value="BH" {{ in_array('BH', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Bahrain (BH)</option>
                        <option value="OM" {{ in_array('OM', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Oman (OM)</option>
                        <option value="US" {{ in_array('US', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>United States (US)</option>
                        <option value="GB" {{ in_array('GB', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>United Kingdom (GB)</option>
                        <option value="DE" {{ in_array('DE', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Germany (DE)</option>
                        <option value="FR" {{ in_array('FR', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>France (FR)</option>
                        <option value="IT" {{ in_array('IT', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Italy (IT)</option>
                        <option value="ES" {{ in_array('ES', old('countries', $shippingZone->countries)) ? 'selected' : '' }}>Spain (ES)</option>
                    </select>
                    @error('countries')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple countries. Use (*) for all other countries.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="base_cost" class="form-label">Base Cost ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('base_cost') is-invalid @enderror"
                               id="base_cost" name="base_cost" value="{{ old('base_cost', $shippingZone->base_cost) }}" required min="0">
                        @error('base_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Flat shipping rate</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="per_kg_cost" class="form-label">Per KG Cost ($)</label>
                        <input type="number" step="0.01" class="form-control @error('per_kg_cost') is-invalid @enderror"
                               id="per_kg_cost" name="per_kg_cost" value="{{ old('per_kg_cost', $shippingZone->per_kg_cost) }}" min="0">
                        @error('per_kg_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Additional cost per kilogram</small>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active"
                               name="is_active" value="1" {{ old('is_active', $shippingZone->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Shipping Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
