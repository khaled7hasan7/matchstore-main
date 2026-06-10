@extends('themes.xylo.layouts.master')

@section('title', __('store.error.404_title'))

@section('css')
<style>
    /* 404 Page Styling */
    .error-page {
        background: linear-gradient(135deg, #fafbfc 0%, #ffffff 100%);
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 0;
    }

    .error-container {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .error-animation {
        position: relative;
        margin-bottom: 40px;
    }

    .error-code {
        font-size: 180px;
        font-weight: 900;
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin: 0;
        position: relative;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .error-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 80px;
        opacity: 0.1;
        animation: spin 20s linear infinite;
    }

    @keyframes spin {
        from {
            transform: translate(-50%, -50%) rotate(0deg);
        }
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .error-title {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .error-message {
        font-size: 16px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--main-color), var(--main-color-light));
        color: #ffffff;
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(132, 204, 22, 0.3);
        color: #ffffff;
    }

    .btn-secondary {
        background: #ffffff;
        color: var(--main-color);
        padding: 14px 32px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid var(--main-color);
    }

    .btn-secondary:hover {
        background: var(--main-color);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(132, 204, 22, 0.15);
    }

    .helpful-links {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 2px solid #e2e8f0;
    }

    .helpful-links-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        max-width: 500px;
        margin: 0 auto;
    }

    .link-item {
        background: #ffffff;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        text-decoration: none;
        color: #475569;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .link-item:hover {
        border-color: var(--main-color);
        background: rgba(132, 204, 22, 0.05);
        color: var(--main-color);
        transform: translateY(-2px);
    }

    .link-item i {
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .error-code {
            font-size: 120px;
        }

        .error-title {
            font-size: 28px;
        }

        .error-message {
            font-size: 14px;
        }

        .error-actions {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="error-page">
    <div class="error-container">
        <div class="error-animation">
            <h1 class="error-code">404</h1>
            <i class="fas fa-compass error-icon"></i>
        </div>

        <h2 class="error-title">{{ __('store.error.404_title') }}</h2>
        <p class="error-message">
            {{ __('store.error.404_message') }}
        </p>

        <div class="error-actions">
            <a href="{{ route('xylo.home') }}" class="btn-primary">
                <i class="fas fa-home"></i>
                {{ __('store.error.back_to_home') }}
            </a>
            <a href="{{ route('shop.index') }}" class="btn-secondary">
                <i class="fas fa-shopping-bag"></i>
                {{ __('store.error.browse_products') }}
            </a>
        </div>

        <div class="helpful-links">
            <h3 class="helpful-links-title">{{ __('store.error.helpful_links') }}</h3>
            <div class="links-grid">
                <a href="{{ route('contact.index') }}" class="link-item">
                    <i class="fas fa-envelope"></i>
                    {{ __('store.error.contact_us') }}
                </a>
                <a href="{{ route('xylo.home') }}#categories" class="link-item">
                    <i class="fas fa-th-large"></i>
                    {{ __('store.error.categories') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
