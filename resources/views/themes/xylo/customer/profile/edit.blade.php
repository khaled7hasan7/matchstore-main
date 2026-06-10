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
   Mobile Profile Styles
   ================================ */

/* Mobile Profile Header */
.mobile-profile-header {
    background: linear-gradient(135deg, {{ config('store.primary_color', '#0e0e0e') }}, #333);
    padding: 20px 16px 60px;
    text-align: center;
    color: white;
}

.mobile-profile-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 12px;
}

.mobile-profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.3);
}

.mobile-profile-camera {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 28px;
    height: 28px;
    background: var(--main-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    cursor: pointer;
    border: 2px solid white;
}

.mobile-profile-name {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 4px;
}

.mobile-profile-email {
    font-size: 13px;
    opacity: 0.85;
}

/* Mobile Profile Content */
.mobile-profile-content {
    padding: 0 16px 100px;
    margin-top: -40px;
    position: relative;
    z-index: 10;
}

/* Mobile Stats Row */
.mobile-profile-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 16px;
}

.mobile-stat-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.mobile-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 16px;
}

.mobile-stat-icon.orders {
    background: linear-gradient(135deg, {{ config('store.primary_color', '#0e0e0e') }}, #333);
    color: white;
}

.mobile-stat-icon.wishlist {
    background: linear-gradient(135deg, {{ config('store.accent_color', '#ffc107') }}, #ff9800);
    color: white;
}

.mobile-stat-value {
    font-size: 20px;
    font-weight: 700;
    color: #212529;
    margin-bottom: 2px;
}

.mobile-stat-label {
    font-size: 12px;
    color: #6c757d;
}

/* Mobile Form Section */
.mobile-form-section {
    background: white;
    border-radius: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
}

.mobile-form-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.mobile-form-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.mobile-form-section-title i {
    color: var(--main-color);
    font-size: 14px;
}

.mobile-form-section-toggle {
    color: #6c757d;
    font-size: 14px;
    transition: transform 0.3s;
}

.mobile-form-section-toggle.rotated {
    transform: rotate(180deg);
}

.mobile-form-section-body {
    padding: 16px;
}

.mobile-form-section-body.collapsed {
    display: none;
}

/* Mobile Form Elements */
.mobile-form-group {
    margin-bottom: 16px;
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

/* Mobile Submit Button */
.mobile-form-submit {
    width: 100%;
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
    margin-top: 16px;
}

.mobile-form-submit.outline {
    background: transparent;
    border: 1px solid {{ config('store.primary_color', '#0e0e0e') }};
    color: {{ config('store.primary_color', '#0e0e0e') }};
}

/* Small Mobile */
@media (max-width: 480px) {
    .mobile-profile-header {
        padding: 16px 12px 50px;
    }

    .mobile-profile-avatar {
        width: 80px;
        height: 80px;
    }

    .mobile-profile-camera {
        width: 26px;
        height: 26px;
        font-size: 11px;
    }

    .mobile-profile-name {
        font-size: 16px;
    }

    .mobile-profile-email {
        font-size: 12px;
    }

    .mobile-profile-content {
        padding: 0 12px 90px;
    }

    .mobile-profile-stats {
        gap: 10px;
    }

    .mobile-stat-card {
        padding: 14px 10px;
    }

    .mobile-stat-icon {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }

    .mobile-stat-value {
        font-size: 18px;
    }

    .mobile-stat-label {
        font-size: 11px;
    }

    .mobile-form-section {
        border-radius: 14px;
    }

    .mobile-form-section-header {
        padding: 14px;
    }

    .mobile-form-section-title {
        font-size: 14px;
    }

    .mobile-form-section-body {
        padding: 14px;
    }

    .mobile-form-input,
    .mobile-form-textarea {
        padding: 12px 14px;
        font-size: 14px;
    }

    .mobile-form-submit {
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
                <h2 class="fw-bold">{{ __('store.profile.title') }}</h2>
                <p class="text-muted">{{ __('store.profile.subtitle') }}</p>
            </div>

            {{-- Profile Image Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img id="profilePreview"
                         src="{{ $customer->profile_image
                             ? asset('storage/' . $customer->profile_image)
                             : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=0D8ABC&color=fff&size=120' }}"
                         alt="Profile"
                         class="profile-avatar mb-3">

                    <h5 class="fw-semibold mb-1">{{ $customer->name }}</h5>
                    <p class="text-muted mb-3">{{ $customer->email }}</p>

                    <label for="profile_image" class="btn btn-outline-dark btn-sm">
                        <i class="fas fa-camera me-2"></i>{{ __('store.profile.change_photo') }}
                    </label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="d-none" form="profileForm">

                    @error('profile_image')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Personal Information Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-user me-2" style="color: {{ config('store.accent_color', '#ffc107') }};"></i>
                        {{ __('store.profile.personal_info') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="profileForm" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Name Field --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('store.profile.name') }}</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name', $customer->name) }}"
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Field --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">{{ __('store.profile.email') }}</label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email', $customer->email) }}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone Field --}}
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">{{ __('store.profile.phone') }}</label>
                                <input type="text"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone', $customer->phone) }}"
                                       class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Address Field --}}
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label fw-semibold">{{ __('store.profile.address') }}</label>
                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          class="form-control @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">
                                <i class="fas fa-save me-2"></i>{{ __('store.profile.save_changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-lock me-2" style="color: {{ config('store.accent_color', '#ffc107') }};"></i>
                        {{ __('store.profile.change_password') }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Current Password --}}
                            <div class="col-md-12 mb-3">
                                <label for="current_password" class="form-label fw-semibold">{{ __('store.profile.current_password') }}</label>
                                <input type="password"
                                       name="current_password"
                                       id="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold">{{ __('store.profile.new_password') }}</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">{{ __('store.profile.password_requirement') }}</small>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">{{ __('store.profile.confirm_new_password') }}</label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-dark btn-lg">
                                <i class="fas fa-key me-2"></i>{{ __('store.profile.update_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, {{ config('store.primary_color', '#0e0e0e') }} 0%, {{ config('store.accent_color', '#ffc107') }} 100%);">
                        <div class="card-body text-center text-white p-4">
                            <i class="fas fa-shopping-cart fa-2x mb-3 opacity-75"></i>
                            <h3 class="fw-bold mb-1">{{ $customer->orders()->count() }}</h3>
                            <p class="mb-0">{{ __('store.profile.total_orders') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, {{ config('store.accent_color', '#ffc107') }} 0%, #ff9800 100%);">
                        <div class="card-body text-center text-white p-4">
                            <i class="fas fa-heart fa-2x mb-3 opacity-75"></i>
                            <h3 class="fw-bold mb-1">{{ $customer->wishlists()->count() }}</h3>
                            <p class="mb-0">{{ __('store.profile.wishlist_items') }}</p>
                        </div>
                    </div>
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

    {{-- Mobile Profile Header --}}
    <div class="mobile-profile-header">
        <div class="mobile-profile-avatar-wrapper">
            <img id="mobileProfilePreview"
                 src="{{ $customer->profile_image
                     ? asset('storage/' . $customer->profile_image)
                     : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=0D8ABC&color=fff&size=120' }}"
                 alt="Profile"
                 class="mobile-profile-avatar">
            <label for="mobile_profile_image" class="mobile-profile-camera">
                <i class="fas fa-camera"></i>
            </label>
            <input type="file" id="mobile_profile_image" name="profile_image" accept="image/*" class="d-none" form="mobileProfileForm">
        </div>
        <div class="mobile-profile-name">{{ $customer->name }}</div>
        <div class="mobile-profile-email">{{ $customer->email }}</div>
    </div>

    {{-- Mobile Profile Content --}}
    <div class="mobile-profile-content">

        {{-- Mobile Stats --}}
        <div class="mobile-profile-stats">
            <div class="mobile-stat-card">
                <div class="mobile-stat-icon orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="mobile-stat-value">{{ $customer->orders()->count() }}</div>
                <div class="mobile-stat-label">{{ __('store.profile.total_orders') }}</div>
            </div>
            <div class="mobile-stat-card">
                <div class="mobile-stat-icon wishlist">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="mobile-stat-value">{{ $customer->wishlists()->count() }}</div>
                <div class="mobile-stat-label">{{ __('store.profile.wishlist_items') }}</div>
            </div>
        </div>

        {{-- Mobile Personal Information Section --}}
        <div class="mobile-form-section">
            <div class="mobile-form-section-header" onclick="toggleSection(this)">
                <h3 class="mobile-form-section-title">
                    <i class="fas fa-user"></i>
                    {{ __('store.profile.personal_info') }}
                </h3>
                <i class="fas fa-chevron-down mobile-form-section-toggle"></i>
            </div>
            <div class="mobile-form-section-body">
                <form id="mobileProfileForm" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.name') }}</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $customer->name) }}"
                               class="mobile-form-input @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.email') }}</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $customer->email) }}"
                               class="mobile-form-input @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.phone') }}</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', $customer->phone) }}"
                               class="mobile-form-input @error('phone') is-invalid @enderror">
                        @error('phone')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.address') }}</label>
                        <textarea name="address"
                                  rows="3"
                                  class="mobile-form-textarea @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="mobile-form-submit">
                        <i class="fas fa-save"></i>
                        {{ __('store.profile.save_changes') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile Change Password Section --}}
        <div class="mobile-form-section">
            <div class="mobile-form-section-header" onclick="toggleSection(this)">
                <h3 class="mobile-form-section-title">
                    <i class="fas fa-lock"></i>
                    {{ __('store.profile.change_password') }}
                </h3>
                <i class="fas fa-chevron-down mobile-form-section-toggle rotated"></i>
            </div>
            <div class="mobile-form-section-body collapsed">
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.current_password') }}</label>
                        <input type="password"
                               name="current_password"
                               class="mobile-form-input @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.new_password') }}</label>
                        <input type="password"
                               name="password"
                               class="mobile-form-input @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="mobile-invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mobile-form-hint">{{ __('store.profile.password_requirement') }}</div>
                    </div>

                    <div class="mobile-form-group">
                        <label class="mobile-form-label">{{ __('store.profile.confirm_new_password') }}</label>
                        <input type="password"
                               name="password_confirmation"
                               class="mobile-form-input">
                    </div>

                    <button type="submit" class="mobile-form-submit outline">
                        <i class="fas fa-key"></i>
                        {{ __('store.profile.update_password') }}
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
{{-- END MOBILE VERSION --}}

<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid {{ config('store.accent_color', '#ffc107') }};
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
    }

    .form-control:focus {
        border-color: {{ config('store.accent_color', '#ffc107') }};
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
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
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .container.py-5 {
            padding-top: 1.5rem !important;
            padding-bottom: 2rem !important;
        }

        .mb-4 h2 {
            font-size: 1.5rem;
        }

        .mb-4 p {
            font-size: 0.9rem;
        }

        .card {
            border-radius: 12px;
        }

        .card:hover {
            transform: none;
        }

        .card-body {
            padding: 1.25rem !important;
        }

        .card-header {
            padding: 1rem 1.25rem;
        }

        .card-header h5 {
            font-size: 1rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-width: 3px;
        }

        .profile-avatar:hover {
            transform: none;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        .form-control {
            padding: 0.65rem 0.85rem;
            font-size: 0.9rem;
        }

        .btn-lg {
            padding: 0.75rem;
            font-size: 0.95rem;
        }

        .row.g-3 .card-body {
            padding: 1.25rem !important;
        }

        .row.g-3 h3 {
            font-size: 1.5rem;
        }

        .row.g-3 p {
            font-size: 0.85rem;
        }

        .row.g-3 i.fa-2x {
            font-size: 1.5rem !important;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .container.py-5 {
            padding-top: 1rem !important;
            padding-bottom: 1.5rem !important;
        }

        .mb-4 h2 {
            font-size: 1.25rem;
        }

        .mb-4 p {
            font-size: 0.8rem;
        }

        .card {
            border-radius: 10px;
            margin-bottom: 1rem !important;
        }

        .card-body {
            padding: 1rem !important;
        }

        .card-header {
            padding: 0.85rem 1rem;
        }

        .card-header h5 {
            font-size: 0.9rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .card-body h5 {
            font-size: 1rem;
        }

        .card-body p.text-muted {
            font-size: 0.8rem;
        }

        .btn-outline-dark.btn-sm {
            padding: 0.4rem 0.85rem;
            font-size: 0.8rem;
        }

        .form-label {
            font-size: 0.8rem;
        }

        .form-control {
            padding: 0.6rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-lg {
            padding: 0.65rem;
            font-size: 0.9rem;
        }

        small.text-muted {
            font-size: 0.75rem;
        }

        .row.g-3 {
            gap: 0.75rem !important;
        }

        .row.g-3 .col-md-6 {
            padding: 0.35rem !important;
        }

        .row.g-3 .card-body {
            padding: 1rem !important;
        }

        .row.g-3 h3 {
            font-size: 1.25rem;
            margin-bottom: 0.25rem !important;
        }

        .row.g-3 p {
            font-size: 0.8rem;
        }

        .row.g-3 i.fa-2x {
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
        }
    }
</style>
@endsection

@section('js')
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('store.profile.success') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

{{-- Live Preview Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Desktop image preview
    const fileInput = document.getElementById('profile_image');
    const previewImg = document.getElementById('profilePreview');

    if (fileInput && previewImg) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Mobile image preview
    const mobileFileInput = document.getElementById('mobile_profile_image');
    const mobilePreviewImg = document.getElementById('mobileProfilePreview');

    if (mobileFileInput && mobilePreviewImg) {
        mobileFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    mobilePreviewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Mobile section toggle
function toggleSection(header) {
    const body = header.nextElementSibling;
    const toggle = header.querySelector('.mobile-form-section-toggle');

    body.classList.toggle('collapsed');
    toggle.classList.toggle('rotated');
}
</script>
@endsection
