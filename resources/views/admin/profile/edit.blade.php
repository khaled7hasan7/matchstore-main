@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.profile.title') }}</h2>
                <p class="page-subtitle">{{ __('cms.profile.setting') ?? 'Manage your profile settings and password' }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - Profile Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center p-4">
                    <!-- Profile Image -->
                    <div class="position-relative d-inline-block mb-3">
                        <img id="profilePreview"
                            src="{{ $admin->profile_image
                                ? (\Illuminate\Support\Str::startsWith($admin->profile_image, ['http://', 'https://'])
                                    ? $admin->profile_image
                                    : asset('storage/' . $admin->profile_image))
                                : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=0d6efd&color=fff&size=150' }}"
                            alt="Profile"
                            class="rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2"
                             style="cursor: pointer; margin-right: 10px;"
                             onclick="document.getElementById('profile_image').click()">
                            <i class="bi bi-camera-fill text-white"></i>
                        </div>
                    </div>

                    <h4 class="mb-1 fw-bold">{{ $admin->name }}</h4>
                    <p class="text-muted mb-3">{{ $admin->email }}</p>

                    <!-- Profile Stats -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="bi bi-shield-check text-primary fs-4 me-2"></i>
                                    <div class="text-start">
                                        <div class="text-muted small">{{ __('cms.sidebar.role') }}</div>
                                        <div class="fw-bold">{{ __('cms.sidebar.admin') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-check text-success fs-4 me-2"></i>
                                    <div class="text-start">
                                        <div class="text-muted small">{{ __('cms.sidebar.joined') }}</div>
                                        <div class="fw-bold">{{ $admin->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Button -->
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="d-none" form="profileForm">

                    @error('profile_image')
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Right Column - Edit Form -->
        <div class="col-lg-8">
            <form method="POST" action="{{ route('admin.profile.update') }}"
                  enctype="multipart/form-data" autocomplete="off" id="profileForm">
                @csrf
                @method('PATCH')

                <!-- Personal Information Card -->
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person-fill text-primary me-2"></i>
                            {{ __('cms.profile.personal_info') ?? 'Personal Information' }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    {{ __('cms.profile.name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $admin->name) }}"
                                       placeholder="{{ __('cms.profile.name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    {{ __('cms.profile.email') }} <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $admin->email) }}"
                                       placeholder="{{ __('cms.profile.email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    {{ __('cms.profile.phone') }}
                                </label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $admin->phone) }}"
                                       placeholder="{{ __('cms.profile.phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security / Password Card -->
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-lock-fill text-warning me-2"></i>
                            {{ __('cms.profile.security') ?? 'Security Settings' }}
                        </h5>
                        <small class="text-muted">{{ __('cms.sidebar.leave_blank') }}</small>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Current Password -->
                            <div class="col-12">
                                <label for="current_password" class="form-label">
                                    {{ __('cms.profile.current_password') }}
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           id="current_password"
                                           name="current_password"
                                           placeholder="{{ __('cms.profile.current_password') }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye-fill" id="current_password_icon"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    {{ __('cms.profile.new_password') }}
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="{{ __('cms.profile.new_password') }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="bi bi-eye-fill" id="password_icon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">{{ __('cms.sidebar.min_8_chars') }}</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    {{ __('cms.profile.confirm_new_password') }}
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="{{ __('cms.profile.confirm_new_password') }}">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye-fill" id="password_confirmation_icon"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-3" id="passwordStrength" style="display: none;">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">{{ __('cms.sidebar.password_strength') }}</small>
                                <small class="fw-bold" id="strengthText"></small>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>
                        {{ __('cms.sidebar.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" id="profileLoader" role="status"></span>
                        <i class="bi bi-check-circle me-2" id="saveIcon"></i>
                        {{ __('cms.profile.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.profile.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const btn = document.getElementById('saveProfileBtn');
    const loader = document.getElementById('profileLoader');
    const saveIcon = document.getElementById('saveIcon');

    form.addEventListener('submit', function() {
        btn.setAttribute('disabled', 'disabled');
        loader.classList.remove('d-none');
        saveIcon.classList.add('d-none');
    });
});

// Profile image preview
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_image');
    const previewImg = document.getElementById('profilePreview');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

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

// Password strength checker
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthIndicator = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;

        if (password.length === 0) {
            strengthIndicator.style.display = 'none';
            return;
        }

        strengthIndicator.style.display = 'block';

        let strength = 0;
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 12.5;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 12.5;

        strengthBar.style.width = strength + '%';

        if (strength < 40) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Weak';
            strengthText.className = 'fw-bold text-danger';
        } else if (strength < 70) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Medium';
            strengthText.className = 'fw-bold text-warning';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Strong';
            strengthText.className = 'fw-bold text-success';
        }
    });
});
</script>
@endsection