@extends('themes.xylo.layouts.master')

@section('title', __('store.contact.title'))

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

    /* Contact Page Styling */
    .contact-page {
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
        min-height: 100vh;
        padding: 40px 0 60px;
    }

    .page-header-contact {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 60px 0;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }

    .page-header-contact::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .page-header-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
        text-align: center;
    }

    .page-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 36px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .page-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 12px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .page-subtitle {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Contact Info Cards */
    .contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .contact-info-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(132, 204, 22, 0.15);
        border-color: var(--main-color);
    }

    .contact-info-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        color: #ffffff;
    }

    .contact-info-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .contact-info-text {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
    }

    .contact-info-text a {
        color: var(--main-color);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-info-text a:hover {
        color: var(--main-color-light);
    }

    /* Contact Form */
    .contact-form-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .form-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--main-color);
        box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        font-size: 13px;
        color: #ef4444;
        margin-top: 6px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        border: none;
        padding: 14px 40px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(132, 204, 22, 0.3);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: #ecfdf5;
        border: 1px solid var(--main-color);
        color: #065f46;
    }

    .alert i {
        font-size: 20px;
    }

    @media (max-width: 768px) {
        .contact-page {
            padding: 20px 0 40px;
        }

        .page-header-contact {
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .page-header-contact::before {
            width: 200px;
            height: 200px;
        }

        .page-icon {
            width: 60px;
            height: 60px;
            font-size: 26px;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .page-title {
            font-size: 1.75rem;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 0.9rem;
        }

        .contact-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .contact-info-card {
            padding: 20px;
            border-radius: 12px;
        }

        .contact-info-card:hover {
            transform: none;
        }

        .contact-info-icon {
            width: 50px;
            height: 50px;
            font-size: 22px;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .contact-info-title {
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .contact-info-text {
            font-size: 0.85rem;
        }

        .contact-form-card {
            padding: 20px;
            border-radius: 12px;
        }

        .form-title {
            font-size: 1.25rem;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 10px 14px;
            font-size: 0.9rem;
            border-radius: 10px;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .submit-btn {
            width: 100%;
            justify-content: center;
            padding: 12px 30px;
            font-size: 0.95rem;
        }

        .alert {
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .alert i {
            font-size: 18px;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .contact-page {
            padding: 15px 0 30px;
        }

        .page-header-contact {
            padding: 30px 0;
            margin-bottom: 20px;
        }

        .page-icon {
            width: 50px;
            height: 50px;
            font-size: 22px;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .page-subtitle {
            font-size: 0.8rem;
        }

        .contact-info-grid {
            gap: 12px;
            margin-bottom: 20px;
        }

        .contact-info-card {
            padding: 15px;
        }

        .contact-info-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .contact-info-title {
            font-size: 0.9rem;
        }

        .contact-info-text {
            font-size: 0.8rem;
        }

        .contact-form-card {
            padding: 15px;
        }

        .form-title {
            font-size: 1.1rem;
        }

        .form-subtitle {
            font-size: 0.8rem;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            font-size: 0.8rem;
        }

        .form-control {
            padding: 9px 12px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        textarea.form-control {
            min-height: 80px;
        }

        .submit-btn {
            padding: 10px 25px;
            font-size: 0.9rem;
            border-radius: 10px;
        }
    }

    /* ================================
       Mobile Contact Styles
       ================================ */

    /* Mobile Contact Header */
    .mobile-contact-header {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        padding: 30px 16px;
        text-align: center;
        color: white;
    }

    .mobile-contact-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 24px;
    }

    .mobile-contact-header h1 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .mobile-contact-header p {
        font-size: 13px;
        opacity: 0.9;
        margin: 0;
    }

    /* Mobile Contact Info Cards */
    .mobile-contact-info {
        padding: 16px;
        background: #f8f9fa;
    }

    .mobile-info-cards {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 8px;
        -webkit-overflow-scrolling: touch;
    }

    .mobile-info-cards::-webkit-scrollbar {
        display: none;
    }

    .mobile-info-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        min-width: 200px;
        flex-shrink: 0;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .mobile-info-card-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: white;
        font-size: 18px;
    }

    .mobile-info-card h3 {
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 6px;
    }

    .mobile-info-card p {
        font-size: 12px;
        color: #6c757d;
        margin: 0;
        line-height: 1.4;
    }

    .mobile-info-card a {
        color: var(--main-color);
        text-decoration: none;
    }

    /* Mobile Contact Form */
    .mobile-contact-form {
        padding: 16px;
    }

    .mobile-form-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    .mobile-form-title {
        font-size: 18px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 6px;
    }

    .mobile-form-subtitle {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .mobile-form-group {
        margin-bottom: 14px;
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

    .mobile-form-input,
    .mobile-form-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .mobile-form-input:focus,
    .mobile-form-textarea:focus {
        outline: none;
        border-color: var(--main-color);
    }

    .mobile-form-input.is-invalid,
    .mobile-form-textarea.is-invalid {
        border-color: #dc3545;
    }

    .mobile-form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .mobile-invalid-feedback {
        font-size: 12px;
        color: #dc3545;
        margin-top: 4px;
    }

    .mobile-submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: white;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 20px;
    }

    .mobile-alert {
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
    }

    .mobile-alert-success {
        background: #d1f4e0;
        color: #198754;
    }
</style>
@endsection

@section('content')

{{-- ================================
    DESKTOP VERSION
    ================================ --}}
<div class="desktop-only">
<div class="contact-page">
    {{-- Page Header --}}
    <div class="page-header-contact">
        <div class="container">
            <div class="page-header-content">
                <div class="page-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h1 class="page-title">{{ __('store.contact.title') }}</h1>
                <p class="page-subtitle">{{ __('store.contact.subtitle') }}</p>
            </div>
        </div>
    </div>

    <div class="container">
        {{-- Contact Info Cards --}}
        <div class="contact-info-grid">
            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="contact-info-title">{{ __('store.contact.address') }}</h3>
                <p class="contact-info-text">
                    {{ $siteSettings->address ?? __('store.contact.address_placeholder') }}
                </p>
            </div>

            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3 class="contact-info-title">{{ __('store.contact.phone') }}</h3>
                <p class="contact-info-text">
                    @if($siteSettings && $siteSettings->phone_1)
                        <a href="tel:{{ $siteSettings->phone_1 }}">{{ $siteSettings->phone_1 }}</a><br>
                    @endif
                    @if($siteSettings && $siteSettings->phone_2)
                        <a href="tel:{{ $siteSettings->phone_2 }}">{{ $siteSettings->phone_2 }}</a>
                    @endif
                    @if(!$siteSettings || (!$siteSettings->phone_1 && !$siteSettings->phone_2))
                        {{ __('store.contact.phone_placeholder') }}
                    @endif
                </p>
            </div>

            <div class="contact-info-card">
                <div class="contact-info-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h3 class="contact-info-title">{{ __('store.contact.email') }}</h3>
                <p class="contact-info-text">
                    @if($siteSettings && $siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
                    @else
                        {{ __('store.contact.email_placeholder') }}
                    @endif
                </p>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="contact-form-card">
            <h2 class="form-title">{{ __('store.contact.form_title') }}</h2>
            <p class="form-subtitle">{{ __('store.contact.form_subtitle') }}</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('store.contact.name') }} <span class="required">*</span>
                            </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="{{ __('store.contact.name_placeholder') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('store.contact.email_label') }} <span class="required">*</span>
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="{{ __('store.contact.email_label_placeholder') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('store.contact.phone_label') }}
                            </label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="{{ __('store.contact.phone_label_placeholder') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('store.contact.subject') }} <span class="required">*</span>
                            </label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                   value="{{ old('subject') }}" placeholder="{{ __('store.contact.subject_placeholder') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        {{ __('store.contact.message') }} <span class="required">*</span>
                    </label>
                    <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                              rows="5" placeholder="{{ __('store.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    {{ __('store.contact.send_message') }}
                </button>
            </form>
        </div>
    </div>
</div>
</div>
{{-- END DESKTOP VERSION --}}

{{-- ================================
    MOBILE VERSION
    ================================ --}}
<div class="mobile-only">

    {{-- Mobile Contact Header --}}
    <div class="mobile-contact-header">
        <div class="mobile-contact-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <h1>{{ __('store.contact.title') }}</h1>
        <p>{{ __('store.contact.subtitle') }}</p>
    </div>

    {{-- Mobile Contact Info Cards --}}
    <div class="mobile-contact-info">
        <div class="mobile-info-cards">
            <div class="mobile-info-card">
                <div class="mobile-info-card-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>{{ __('store.contact.address') }}</h3>
                <p>{{ $siteSettings->address ?? __('store.contact.address_placeholder') }}</p>
            </div>

            <div class="mobile-info-card">
                <div class="mobile-info-card-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>{{ __('store.contact.phone') }}</h3>
                <p>
                    @if($siteSettings && $siteSettings->phone_1)
                        <a href="tel:{{ $siteSettings->phone_1 }}">{{ $siteSettings->phone_1 }}</a>
                    @else
                        {{ __('store.contact.phone_placeholder') }}
                    @endif
                </p>
            </div>

            <div class="mobile-info-card">
                <div class="mobile-info-card-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h3>{{ __('store.contact.email') }}</h3>
                <p>
                    @if($siteSettings && $siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}">{{ $siteSettings->email }}</a>
                    @else
                        {{ __('store.contact.email_placeholder') }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Mobile Contact Form --}}
    <div class="mobile-contact-form">
        <div class="mobile-form-card">
            <h2 class="mobile-form-title">{{ __('store.contact.form_title') }}</h2>
            <p class="mobile-form-subtitle">{{ __('store.contact.form_subtitle') }}</p>

            @if(session('success'))
                <div class="mobile-alert mobile-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.contact.name') }} <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="mobile-form-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="{{ __('store.contact.name_placeholder') }}">
                    @error('name')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.contact.email_label') }} <span class="required">*</span>
                    </label>
                    <input type="email" name="email" class="mobile-form-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="{{ __('store.contact.email_label_placeholder') }}">
                    @error('email')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.contact.phone_label') }}
                    </label>
                    <input type="tel" name="phone" class="mobile-form-input @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}" placeholder="{{ __('store.contact.phone_label_placeholder') }}">
                    @error('phone')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.contact.subject') }} <span class="required">*</span>
                    </label>
                    <input type="text" name="subject" class="mobile-form-input @error('subject') is-invalid @enderror"
                           value="{{ old('subject') }}" placeholder="{{ __('store.contact.subject_placeholder') }}">
                    @error('subject')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mobile-form-group">
                    <label class="mobile-form-label">
                        {{ __('store.contact.message') }} <span class="required">*</span>
                    </label>
                    <textarea name="message" class="mobile-form-textarea @error('message') is-invalid @enderror"
                              rows="4" placeholder="{{ __('store.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="mobile-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mobile-submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    {{ __('store.contact.send_message') }}
                </button>
            </form>
        </div>
    </div>

</div>
{{-- END MOBILE VERSION --}}

@endsection
