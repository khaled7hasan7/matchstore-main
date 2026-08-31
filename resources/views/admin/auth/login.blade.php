@extends('admin.layouts.login')

@section('css')
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Cairo', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    overflow: hidden;
}

.modern-login-wrapper {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

/* Left Side - Branding */
.login-branding {
    flex: 1;
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.branding-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.logo-section {
    margin-bottom: 3rem;
    animation: fadeInUp 0.8s ease;
}

.brand-logo {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin-bottom: 1.5rem;
    filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
}

.brand-name {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
}

.welcome-text {
    margin-bottom: 2rem;
    animation: fadeInUp 0.8s ease 0.2s both;
}

.welcome-text h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #4299e1;
}

.welcome-text p {
    font-size: 1rem;
    color: #cbd5e0;
    line-height: 1.6;
}

/* Decorative Elements */
.decorative-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
    pointer-events: none;
}

.circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(66, 153, 225, 0.1);
    animation: float 20s infinite ease-in-out;
}

.circle-1 {
    width: 300px;
    height: 300px;
    top: -100px;
    right: -100px;
    animation-delay: 0s;
}

.circle-2 {
    width: 200px;
    height: 200px;
    bottom: -50px;
    left: -50px;
    animation-delay: 5s;
}

.circle-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    left: 10%;
    animation-delay: 10s;
}

/* Right Side - Form */
.login-form-section {
    flex: 1;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.form-container {
    width: 100%;
    max-width: 450px;
    background: white;
    padding: 3rem;
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    animation: fadeInRight 0.8s ease;
}

.form-header {
    margin-bottom: 2.5rem;
    text-align: center;
}

.form-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.form-header p {
    color: #718096;
    font-size: 0.95rem;
}

/* Modern Alerts */
.alert-modern {
    padding: 1rem 1.25rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.3s ease;
}

.alert-danger {
    background: #fff5f5;
    border: 1px solid #fc8181;
    color: #c53030;
}

.alert-modern i {
    font-size: 1.125rem;
}

/* Form Groups */
.modern-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group-modern {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label-modern {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label-modern i {
    color: #4299e1;
    font-size: 0.875rem;
}

.form-control-modern {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f7fafc;
}

.form-control-modern:focus {
    outline: none;
    border-color: #4299e1;
    background: white;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

/* Password Input Wrapper */
.password-input-wrapper {
    position: relative;
}

.password-input-wrapper .form-control-modern {
    padding-right: 3rem;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #718096;
    cursor: pointer;
    transition: color 0.3s ease;
    padding: 0.25rem;
}

.password-toggle:hover {
    color: #4299e1;
}

/* Form Options */
.form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-modern {
    width: 1.125rem;
    height: 1.125rem;
    cursor: pointer;
    accent-color: #4299e1;
}

.checkbox-label {
    color: #4a5568;
    font-size: 0.875rem;
    cursor: pointer;
    user-select: none;
}

/* Modern Button */
.btn-modern {
    width: 100%;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(66, 153, 225, 0.4);
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 153, 225, 0.5);
}

.btn-primary-modern:active {
    transform: translateY(0);
}

/* RTL Support */
[dir="rtl"] .form-label-modern {
    flex-direction: row-reverse;
}

[dir="rtl"] .password-toggle {
    right: auto;
    left: 1rem;
}

[dir="rtl"] .password-input-wrapper .form-control-modern {
    padding-right: 1rem;
    padding-left: 3rem;
}

[dir="rtl"] .alert-modern {
    flex-direction: row-reverse;
}

[dir="rtl"] .btn-modern {
    flex-direction: row-reverse;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -30px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

/* Responsive Design */
@media (max-width: 968px) {
    .modern-login-wrapper {
        flex-direction: column;
    }

    .login-branding {
        min-height: 40vh;
        padding: 2rem;
    }

    .brand-logo {
        width: 80px;
        height: 80px;
    }

    .brand-name {
        font-size: 2rem;
    }

    .welcome-text h2 {
        font-size: 1.5rem;
    }

    .login-form-section {
        padding: 2rem 1.5rem;
    }

    .form-container {
        padding: 2rem;
    }
}

@media (max-width: 576px) {
    .form-container {
        padding: 1.5rem;
    }

    .form-header h2 {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="modern-login-wrapper">
    <!-- Left Side - Branding -->
    <div class="login-branding">
        <div class="branding-content">
            <div class="logo-section">
                @if($siteSettings && $siteSettings->logo)
                    <img src="{{ store_image($siteSettings->logo) }}"
                         alt="{{ $siteSettings->site_name ?? cms_translate('auth.velstore') }}"
                         class="brand-logo">
                @endif
                <h1 class="brand-name">{{ $siteSettings->site_name ?? cms_translate('auth.velstore') }}</h1>
            </div>
            <div class="welcome-text">
                <h2>{{ __('cms.auth.welcome_back') }}</h2>
                <p>{{ __('cms.auth.admin_portal_desc') }}</p>
            </div>
            <div class="decorative-elements">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="login-form-section">
        <div class="form-container">
            <div class="form-header">
                <h2>{{ cms_translate('auth.login') }}</h2>
                <p>{{ __('cms.auth.enter_credentials') }}</p>
            </div>

            @error('password')
                <div class="alert-modern alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
            @error('email')
                <div class="alert-modern alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <form method="POST" action="{{ route('login') }}" autocomplete="off" class="modern-form">
                @csrf

                <div class="form-group-modern">
                    <label for="email" class="form-label-modern">
                        <i class="fas fa-envelope"></i>
                        {{ cms_translate('auth.email') }}
                    </label>
                    <input
                        type="email"
                        class="form-control-modern"
                        name="email"
                        value="{{ old('email') }}"
                        id="email"
                        placeholder="{{ cms_translate('auth.email') }}"
                        required
                        autofocus>
                </div>

                <div class="form-group-modern">
                    <label for="password" class="form-label-modern">
                        <i class="fas fa-lock"></i>
                        {{ cms_translate('auth.password') }}
                    </label>
                    <div class="password-input-wrapper">
                        <input
                            type="password"
                            class="form-control-modern"
                            name="password"
                            id="password"
                            placeholder="{{ cms_translate('auth.password') }}"
                            required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" class="checkbox-modern" id="rememberMe" name="remember">
                        <label class="checkbox-label" for="rememberMe">
                            {{ cms_translate('auth.remember_me') }}
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-modern btn-primary-modern">
                    <span>{{ cms_translate('auth.login') }}</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection

