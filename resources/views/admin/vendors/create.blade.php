@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.vendors.register_new_vendor') }}</h2>
                <p class="page-subtitle">{{ __('cms.vendors.create_subtitle') ?? 'Register a new vendor account' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.vendors.back') ?? 'Back' }}
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

            {{-- Registration Form --}}
            <form action="{{ route('admin.vendors.store') }}" method="POST" autocomplete="off">
                @csrf

                {{-- Vendor Information Section --}}
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            {{ __('cms.vendors.vendor_name') }} <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               maxlength="255"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            {{ __('cms.vendors.vendor_email') }} <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               maxlength="255"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('cms.vendors.phone_optional') }}</label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}"
                               maxlength="20">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">
                            {{ __('cms.vendors.status') }} <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>
                                {{ __('cms.vendors.active') }}
                            </option>
                            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>
                                {{ __('cms.vendors.inactive') }}
                            </option>
                            <option value="banned" {{ old('status')=='banned' ? 'selected' : '' }}>
                                {{ __('cms.vendors.banned') }}
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            {{ __('cms.vendors.password') }} <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="new-password"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="bi bi-eye-fill" id="password_icon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">{{ __('cms.vendors.min_8_chars') ?? 'Minimum 8 characters' }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            {{ __('cms.vendors.confirm_password') }} <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   autocomplete="new-password"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye-fill" id="password_confirmation_icon"></i>
                            </button>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>{{ __('cms.vendors.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.vendors.register_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye-fill');
        icon.classList.add('bi-eye-slash-fill');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash-fill');
        icon.classList.add('bi-eye-fill');
    }
}
</script>
@endsection