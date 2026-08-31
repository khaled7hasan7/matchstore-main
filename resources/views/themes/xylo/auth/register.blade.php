@extends('themes.xylo.layouts.auth')

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="auth-container">
    <div class="row g-0 min-vh-100">

        {{-- Left Section: Branding --}}
        <div class="col-lg-6 auth-branding d-flex flex-column justify-content-center align-items-center text-white px-5 py-5"
             style="background-color: {{ config('store.primary_color', '#0e0e0e') }};">

            {{-- Logo --}}
            <div class="auth-logo mb-4">
                @if($siteSettings && $siteSettings->logo)
                    <img src="{{ store_image($siteSettings->logo) }}"
                         alt="{{ $siteSettings->site_name ?? 'Logo' }}"
                         class="img-fluid"
                         style="max-width: 180px;">
                @else
                    <img src="https://i.ibb.co/dHx2ZR3/velstore.png"
                         alt="Logo"
                         class="img-fluid"
                         style="max-width: 180px;">
                @endif
            </div>

            {{-- Welcome Message --}}
            <h2 class="fw-bold mb-3 text-center">{{ __('store.register.join_us') }}</h2>
            <p class="text-light mb-4 text-center opacity-75" style="max-width: 400px;">
                {{ __('store.register.signup_description') }}
            </p>

            {{-- Decorative Element --}}
            <div class="mt-5">
                <div class="auth-decoration">
                    <i class="fas fa-user-plus fa-3x opacity-25"></i>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-auto text-center opacity-75 small pt-4">
                © {{ date('Y') }} {{ $siteSettings->site_name ?? 'MatchStore' }}
            </div>
        </div>

        {{-- Right Section: Register Form --}}
        <div class="col-lg-6 auth-form-section d-flex flex-column justify-content-center align-items-center bg-white px-5 py-5">

            <div class="auth-form-container" style="max-width: 450px; width: 100%;">

                {{-- Form Header --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">{{ __('store.register.signup_now') }}</h3>
                    <p class="text-muted">{{ __('store.register.form_subtitle') }}</p>
                </div>

                {{-- Register Form --}}
                <form method="POST" action="{{ route('customer.register') }}">
                    @csrf

                    {{-- Name Field --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">{{ __('store.register.name') }}</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                               required
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">{{ __('store.register.email') }}</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">{{ __('store.register.password') }}</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">{{ __('store.register.password_hint') }}</small>
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">{{ __('store.register.confirm_password') }}</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control form-control-lg"
                               required>
                    </div>

                    {{-- Terms Acceptance --}}
                    <div class="form-check mb-4">
                        <input type="checkbox"
                               name="terms"
                               id="terms"
                               class="form-check-input"
                               required>
                        <label class="form-check-label small" for="terms">
                            {{ __('store.register.agree_to') }}
                            <a href="{{ route('page.show', 'terms-of-service') }}"
                               target="_blank"
                               class="text-decoration-none"
                               style="color: {{ config('store.accent_color', '#ffc107') }};">
                                {{ __('store.register.terms') }}
                            </a>
                            {{ __('store.register.and') }}
                            <a href="{{ route('page.show', 'privacy-policy') }}"
                               target="_blank"
                               class="text-decoration-none"
                               style="color: {{ config('store.accent_color', '#ffc107') }};">
                                {{ __('store.register.privacy') }}
                            </a>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            class="btn btn-lg w-100 text-white fw-semibold mb-3 auth-submit-btn"
                            style="background-color: {{ config('store.primary_color', '#0e0e0e') }};">
                        {{ __('store.register.signup_btn') }}
                    </button>

                    {{-- Login Link --}}
                    <div class="text-center">
                        <span class="text-muted">{{ __('store.register.already_account') }}</span>
                        <a href="{{ route('customer.login') }}"
                           class="text-decoration-none fw-semibold ms-1"
                           style="color: {{ config('store.accent_color', '#ffc107') }};">
                            {{ __('store.register.login_here') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only mobile-auth-page">

    {{-- Mobile Auth Header --}}
    <div class="mobile-auth-header">
        <div class="mobile-auth-logo">
            @if($siteSettings && $siteSettings->logo)
                <img src="{{ store_image($siteSettings->logo) }}" alt="{{ $siteSettings->site_name ?? 'Logo' }}">
            @else
                <img src="https://i.ibb.co/dHx2ZR3/velstore.png" alt="Logo">
            @endif
        </div>
        <h1>{{ __('store.register.join_us') }}</h1>
        <p>{{ __('store.register.signup_description') }}</p>
    </div>

    {{-- Mobile Auth Form --}}
    <div class="mobile-auth-form-wrapper">
        <div class="mobile-auth-form">
            <h2 class="mobile-auth-form-title">{{ __('store.register.signup_now') }}</h2>
            <p class="mobile-auth-form-subtitle">{{ __('store.register.form_subtitle') }}</p>

            <form method="POST" action="{{ route('customer.register') }}">
                @csrf

                <div class="mobile-form-group">
                    <label class="mobile-form-label">{{ __('store.register.name') }}</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="mobile-form-input @error('name') is-invalid @enderror"
                           required
                           autofocus>
                    @error('name')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">{{ __('store.register.email') }}</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="mobile-form-input @error('email') is-invalid @enderror"
                           required>
                    @error('email')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">{{ __('store.register.password') }}</label>
                    <input type="password"
                           name="password"
                           class="mobile-form-input @error('password') is-invalid @enderror"
                           required>
                    @error('password')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mobile-password-hint">{{ __('store.register.password_hint') }}</div>
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">{{ __('store.register.confirm_password') }}</label>
                    <input type="password"
                           name="password_confirmation"
                           class="mobile-form-input"
                           required>
                </div>

                <div class="mobile-terms-wrap">
                    <input type="checkbox" name="terms" id="mobile-terms" required>
                    <label for="mobile-terms">
                        {{ __('store.register.agree_to') }}
                        <a href="{{ route('page.show', 'terms-of-service') }}" target="_blank">{{ __('store.register.terms') }}</a>
                        {{ __('store.register.and') }}
                        <a href="{{ route('page.show', 'privacy-policy') }}" target="_blank">{{ __('store.register.privacy') }}</a>
                    </label>
                </div>

                <button type="submit" class="mobile-auth-submit">
                    {{ __('store.register.signup_btn') }}
                </button>

                <div class="mobile-auth-footer">
                    <span>{{ __('store.register.already_account') }}</span>
                    <a href="{{ route('customer.login') }}">{{ __('store.register.login_here') }}</a>
                </div>
            </form>
        </div>
    </div>

</div>
{{-- END MOBILE VERSION --}}

<style>
    .auth-container {
        min-height: 100vh;
    }

    .auth-branding {
        position: relative;
    }

    .auth-decoration {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .auth-form-section {
        background-color: #f8f9fa;
    }

    .auth-submit-btn {
        transition: all 0.3s ease;
    }

    .auth-submit-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .form-control:focus {
        border-color: {{ config('store.accent_color', '#ffc107') }};
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    .form-check-input:checked {
        background-color: {{ config('store.accent_color', '#ffc107') }};
        border-color: {{ config('store.accent_color', '#ffc107') }};
    }

    @media (max-width: 991px) {
        .auth-branding {
            padding: 2.5rem 1.5rem !important;
            min-height: auto;
        }

        .auth-form-section {
            padding: 2.5rem 1.5rem !important;
        }

        .auth-logo img {
            max-width: 120px !important;
        }

        .auth-branding h2 {
            font-size: 1.5rem;
        }

        .auth-branding p {
            font-size: 0.9rem;
        }

        .auth-decoration {
            display: none;
        }

        .auth-branding .mt-auto {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .auth-branding {
            padding: 2rem 1.25rem !important;
        }

        .auth-form-section {
            padding: 2rem 1.25rem !important;
        }

        .auth-logo img {
            max-width: 100px !important;
        }

        .auth-branding h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem !important;
        }

        .auth-branding p {
            font-size: 0.85rem;
            margin-bottom: 0 !important;
        }

        .auth-form-container h3 {
            font-size: 1.25rem;
        }

        .auth-form-container p {
            font-size: 0.85rem;
        }

        .form-control-lg {
            padding: 0.65rem 0.85rem;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
        }

        .mb-3 {
            margin-bottom: 0.85rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .btn-lg {
            padding: 0.75rem;
            font-size: 0.95rem;
        }

        .form-check-label {
            font-size: 0.8rem;
        }

        .text-center .text-muted,
        .text-center a {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 480px) {
        .auth-branding {
            padding: 1.5rem 1rem !important;
        }

        .auth-form-section {
            padding: 1.5rem 1rem !important;
        }

        .auth-logo img {
            max-width: 80px !important;
        }

        .auth-branding h2 {
            font-size: 1.1rem;
        }

        .auth-branding p {
            font-size: 0.8rem;
        }

        .auth-form-container h3 {
            font-size: 1.1rem;
        }

        .auth-form-container p {
            font-size: 0.8rem;
        }

        .form-control-lg {
            padding: 0.6rem 0.75rem;
            font-size: 0.85rem;
        }

        .form-label {
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 0.65rem;
            font-size: 0.9rem;
        }

        .form-check-label.small {
            font-size: 0.75rem;
        }
    }

    /* Desktop/Mobile visibility */
    .desktop-only {
        display: block;
    }

    .mobile-only {
        display: none !important;
    }

    @media (max-width: 768px) {
        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: block !important;
        }
    }

    /* Mobile Auth Styles */
    .mobile-auth-page {
        min-height: 100vh;
        background: #f8f9fa;
    }

    .mobile-auth-header {
        background: linear-gradient(135deg, {{ config('store.primary_color', '#0e0e0e') }}, #333);
        padding: 30px 20px 40px;
        text-align: center;
        color: white;
        border-radius: 0 0 30px 30px;
    }

    .mobile-auth-logo {
        margin-bottom: 12px;
    }

    .mobile-auth-logo img {
        max-width: 80px;
        height: auto;
    }

    .mobile-auth-header h1 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .mobile-auth-header p {
        font-size: 12px;
        opacity: 0.85;
        margin: 0;
    }

    .mobile-auth-form-wrapper {
        padding: 16px;
        margin-top: -25px;
        position: relative;
        z-index: 10;
    }

    .mobile-auth-form {
        background: white;
        border-radius: 20px;
        padding: 20px 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .mobile-auth-form-title {
        font-size: 17px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 4px;
        text-align: center;
    }

    .mobile-auth-form-subtitle {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 20px;
        text-align: center;
    }

    .mobile-form-group {
        margin-bottom: 14px;
    }

    .mobile-form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 5px;
    }

    .mobile-form-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
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

    .mobile-invalid-feedback {
        font-size: 11px;
        color: #dc3545;
        margin-top: 4px;
    }

    .mobile-password-hint {
        font-size: 11px;
        color: #6c757d;
        margin-top: 4px;
    }

    .mobile-terms-wrap {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 18px;
    }

    .mobile-terms-wrap input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        accent-color: var(--main-color);
        flex-shrink: 0;
    }

    .mobile-terms-wrap label {
        font-size: 11px;
        color: #495057;
        line-height: 1.4;
    }

    .mobile-terms-wrap a {
        color: var(--main-color);
        text-decoration: none;
    }

    .mobile-auth-submit {
        width: 100%;
        background: {{ config('store.primary_color', '#0e0e0e') }};
        color: white;
        border: none;
        padding: 13px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 14px;
    }

    .mobile-auth-footer {
        text-align: center;
        font-size: 12px;
        color: #6c757d;
    }

    .mobile-auth-footer a {
        color: var(--main-color);
        text-decoration: none;
        font-weight: 600;
    }
</style>
@endsection
