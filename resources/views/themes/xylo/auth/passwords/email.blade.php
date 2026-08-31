@extends('themes.xylo.layouts.auth')

@section('content')
<div class="auth-container">
    <div class="row g-0 min-vh-100 justify-content-center align-items-center">
        <div class="col-lg-5 col-md-8 col-11">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        @if($siteSettings && $siteSettings->logo)
                            <img src="{{ store_image($siteSettings->logo) }}"
                                 alt="{{ $siteSettings->site_name ?? 'Logo' }}" class="img-fluid mb-3" style="max-width: 140px;">
                        @endif
                        <h3 class="fw-bold mb-2">{{ __('store.login.forgot_password') }}</h3>
                        <p class="text-muted">{{ __('store.login.email') }}</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('customer.password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('store.login.email') }}</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email') }}"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit"
                                class="btn btn-lg w-100 text-white fw-semibold mb-3"
                                style="background-color: {{ config('store.primary_color', '#0e0e0e') }};">
                            {{ __('store.login.login_btn') }}
                        </button>

                        <div class="text-center">
                            <a href="{{ route('customer.login') }}" class="text-decoration-none"
                               style="color: {{ config('store.accent_color', '#ffc107') }};">
                                {{ __('store.login.login_now') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
