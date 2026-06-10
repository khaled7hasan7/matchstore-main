@extends('admin.layouts.admin')

@section('css')
<style>
    /* Theme Preset Cards */
    .theme-preset-card {
        position: relative;
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .theme-preset-card:hover {
        border-color: #aaa;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .theme-preset-radio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .theme-preset-radio:checked + .theme-preset-label {
        border: 2px solid #0d6efd;
        background-color: #e7f1ff;
        border-radius: 10px;
    }

    .theme-preset-label {
        display: block;
        padding: 15px;
        cursor: pointer;
        margin: 0;
        transition: all 0.3s ease;
    }

    .theme-preview-colors {
        display: flex;
        gap: 5px;
        margin-bottom: 10px;
        justify-content: center;
    }

    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .theme-name {
        text-align: center;
        font-weight: 600;
        color: #333;
        margin-top: 10px;
    }

    /* Color Picker Styling */
    .form-control-color {
        max-width: 60px;
        height: 40px;
        border: none;
        cursor: pointer;
    }

    /* Theme Preview Box */
    .theme-preview-box {
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 15px;
    }
</style>
@endsection

@section('content')

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.site_settings.edit_title') }}</h6>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                            <i class="fas fa-cog me-2"></i>{{ __('cms.site_settings.tab_general') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                            <i class="fas fa-address-book me-2"></i>{{ __('cms.site_settings.tab_contact') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">
                            <i class="fas fa-search me-2"></i>{{ __('cms.site_settings.tab_seo') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="branding-tab" data-bs-toggle="tab" data-bs-target="#branding" type="button" role="tab" aria-controls="branding" aria-selected="false">
                            <i class="fas fa-palette me-2"></i>{{ __('cms.site_settings.tab_branding') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab" aria-controls="theme" aria-selected="false">
                            <i class="fas fa-paint-brush me-2"></i>{{ __('cms.site_settings.tab_theme') }}
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="settingsTabContent">

                    <!-- General Tab -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="form-group mb-3">
                            <label for="site_name">{{ __('cms.site_settings.site_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" id="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings->site_name ?? '') }}" required>
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tagline">{{ __('cms.site_settings.tagline') }}</label>
                            <input type="text" name="tagline" id="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $settings->tagline ?? '') }}">
                            <small class="form-text text-muted">{{ __('cms.site_settings.tagline_help') }}</small>
                            @error('tagline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="default_currency">{{ __('cms.site_settings.default_currency') }}</label>
                                    <select name="default_currency" id="default_currency" class="form-control @error('default_currency') is-invalid @enderror">
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->code }}" {{ old('default_currency', $settings->default_currency ?? 'USD') == $currency->code ? 'selected' : '' }}>
                                                {{ $currency->symbol }} {{ strtoupper($currency->code) }} - {{ $currency->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">{{ __('cms.site_settings.default_currency_help') }}</small>
                                    @error('default_currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="default_language">{{ __('cms.site_settings.default_language') }}</label>
                                    <select name="default_language" id="default_language" class="form-control @error('default_language') is-invalid @enderror">
                                        @foreach($languages as $code => $name)
                                            <option value="{{ $code }}" {{ old('default_language', $settings->default_language ?? 'en') == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">{{ __('cms.site_settings.default_language_help') }}</small>
                                    @error('default_language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Tab -->
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="form-group mb-3">
                            <label for="contact_email">{{ __('cms.site_settings.contact_email') }}</label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $settings->contact_email ?? '') }}">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_phone">{{ __('cms.site_settings.contact_phone') }}</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $settings->contact_phone ?? '') }}">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_phone_2">{{ __('cms.site_settings.contact_phone_2') }}</label>
                            <input type="text" name="contact_phone_2" id="contact_phone_2" class="form-control @error('contact_phone_2') is-invalid @enderror" value="{{ old('contact_phone_2', $settings->contact_phone_2 ?? '') }}">
                            <small class="form-text text-muted">{{ __('cms.site_settings.contact_phone_2_help') }}</small>
                            @error('contact_phone_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">{{ __('cms.site_settings.address') }}</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $settings->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="form-group mb-3">
                            <label for="meta_title">{{ __('cms.site_settings.meta_title') }}</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $settings->meta_title ?? '') }}">
                            <small class="form-text text-muted">{{ __('cms.site_settings.meta_title_help') }}</small>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_description">{{ __('cms.site_settings.meta_description') }}</label>
                            <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="3">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                            <small class="form-text text-muted">{{ __('cms.site_settings.meta_description_help') }}</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_keywords">{{ __('cms.site_settings.meta_keywords') }}</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror" value="{{ old('meta_keywords', $settings->meta_keywords ?? '') }}">
                            <small class="form-text text-muted">{{ __('cms.site_settings.meta_keywords_help') }}</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="footer_text">{{ __('cms.site_settings.footer_text') }}</label>
                            <textarea name="footer_text" id="footer_text" class="form-control @error('footer_text') is-invalid @enderror" rows="2">{{ old('footer_text', $settings->footer_text ?? '') }}</textarea>
                            <small class="form-text text-muted">{{ __('cms.site_settings.footer_text_help') }}</small>
                            @error('footer_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Branding Tab -->
                    <div class="tab-pane fade" id="branding" role="tabpanel" aria-labelledby="branding-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="logo">{{ __('cms.site_settings.logo') }}</label>
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp" onchange="previewLogo(this)">
                                    <small class="form-text text-muted">{{ __('cms.site_settings.logo_help') }}</small>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Logo Preview -->
                                    <div class="mt-3">
                                        <label class="d-block">{{ __('cms.site_settings.current_logo') }}:</label>
                                        @if($settings && $settings->logo)
                                            <img id="logoPreview" src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 150px;">
                                        @else
                                            <img id="logoPreview" src="{{ asset('images/placeholder-logo.png') }}" alt="Logo Preview" class="img-thumbnail d-none" style="max-height: 150px;">
                                            <p class="text-muted">{{ __('cms.site_settings.no_logo_uploaded') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="favicon">{{ __('cms.site_settings.favicon') }}</label>
                                    <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/x-icon" onchange="previewFavicon(this)">
                                    <small class="form-text text-muted">{{ __('cms.site_settings.favicon_help') }}</small>
                                    @error('favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Favicon Preview -->
                                    <div class="mt-3">
                                        <label class="d-block">{{ __('cms.site_settings.current_favicon') }}:</label>
                                        @if($settings && $settings->favicon)
                                            <img id="faviconPreview" src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" class="img-thumbnail" style="max-height: 64px;">
                                        @else
                                            <img id="faviconPreview" src="{{ asset('images/placeholder-favicon.png') }}" alt="Favicon Preview" class="img-thumbnail d-none" style="max-height: 64px;">
                                            <p class="text-muted">{{ __('cms.site_settings.no_favicon_uploaded') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Tab -->
                    <div class="tab-pane fade" id="theme" role="tabpanel" aria-labelledby="theme-tab">
                        <div id="theme-form" data-action="{{ route('admin.site-settings.theme.update') }}">
                            @csrf

                            <!-- Debug Information -->
                            <div class="alert alert-info mb-4">
                                <h6><i class="fas fa-bug"></i> Debug Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Current Settings:</strong><br>
                                        <small>
                                            Theme Preset: <code>{{ getWebConfig('theme_preset', 'NOT SET') }}</code><br>
                                            Custom Enabled: <code>{{ getWebConfig('theme_custom_enabled', 'NOT SET') }}</code><br>
                                            Primary Color: <code>{{ getWebConfig('theme_primary_color', 'NOT SET') }}</code><br>
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Database Check:</strong><br>
                                        <small>
                                            @php
                                                $dbPreset = \App\Models\StoreSetting::where('key', 'theme_preset')->first();
                                                $dbCustom = \App\Models\StoreSetting::where('key', 'theme_custom_enabled')->first();
                                                $dbPrimary = \App\Models\StoreSetting::where('key', 'theme_primary_color')->first();
                                            @endphp
                                            DB Preset: <code>{{ $dbPreset ? $dbPreset->value : 'NULL' }}</code><br>
                                            DB Custom: <code>{{ $dbCustom ? $dbCustom->value : 'NULL' }}</code><br>
                                            DB Primary: <code>{{ $dbPrimary ? $dbPrimary->value : 'NULL' }}</code><br>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Preset Theme Selection -->
                            <div class="mb-4">
                                <h5>{{ __('cms.site_settings.theme_presets') }}</h5>
                                <p class="text-muted small">{{ __('cms.site_settings.theme_presets_help') }}</p>

                                <div class="row g-3">
                                    @foreach(config('theme.presets') as $key => $preset)
                                    <div class="col-md-4">
                                        <div class="theme-preset-card">
                                            <input type="radio" name="theme_preset" id="preset_{{ $key }}" value="{{ $key }}"
                                                   {{ getWebConfig('theme_preset', 'default') === $key ? 'checked' : '' }}
                                                   class="theme-preset-radio">
                                            <label for="preset_{{ $key }}" class="theme-preset-label">
                                                <div class="theme-preview-colors">
                                                    <span class="color-preview" style="background: {{ $preset['primary'] }}"></span>
                                                    <span class="color-preview" style="background: {{ $preset['primary_light'] }}"></span>
                                                    <span class="color-preview" style="background: {{ $preset['secondary'] }}"></span>
                                                    <span class="color-preview" style="background: {{ $preset['card_bg'] }}"></span>
                                                </div>
                                                <div class="theme-name">{{ __($preset['name_key']) }}</div>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Custom Colors Toggle -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="theme_custom_enabled" id="theme_custom_enabled"
                                           class="form-check-input" value="1"
                                           {{ getWebConfig('theme_custom_enabled', '0') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="theme_custom_enabled">
                                        <strong>{{ __('cms.site_settings.enable_custom_colors') }}</strong>
                                    </label>
                                </div>
                                <small class="form-text text-muted">{{ __('cms.site_settings.enable_custom_colors_help') }}</small>
                            </div>

                            <!-- Custom Color Pickers -->
                            <div id="custom-colors-section" style="{{ getWebConfig('theme_custom_enabled', '0') === '1' ? 'display: block;' : 'display: none;' }}">
                                <h5>{{ __('cms.site_settings.custom_colors') }}</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="theme_primary_color">{{ __('cms.site_settings.primary_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_primary_color" id="theme_primary_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_primary_color', '#000000') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_primary_color', '#000000') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.primary_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_primary_light_color">{{ __('cms.site_settings.primary_light_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_primary_light_color" id="theme_primary_light_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_primary_light_color', '#777777') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_primary_light_color', '#777777') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.primary_light_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_secondary_color">{{ __('cms.site_settings.secondary_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_secondary_color" id="theme_secondary_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_secondary_color', '#333333') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_secondary_color', '#333333') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.secondary_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_background_color">{{ __('cms.site_settings.background_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_background_color" id="theme_background_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_background_color', '#ffffff') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_background_color', '#ffffff') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.background_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_card_background_color">{{ __('cms.site_settings.card_bg_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_card_background_color" id="theme_card_background_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_card_background_color', '#f5f5f5') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_card_background_color', '#f5f5f5') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.card_bg_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_text_color">{{ __('cms.site_settings.text_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_text_color" id="theme_text_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_text_color', '#111111') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_text_color', '#111111') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.text_color_help') }}</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme_border_color">{{ __('cms.site_settings.border_color') }}</label>
                                        <div class="input-group">
                                            <input type="color" name="theme_border_color" id="theme_border_color"
                                                   class="form-control form-control-color"
                                                   value="{{ getWebConfig('theme_border_color', '#bbbbbb') }}">
                                            <input type="text" class="form-control color-text-input"
                                                   value="{{ getWebConfig('theme_border_color', '#bbbbbb') }}"
                                                   readonly>
                                        </div>
                                        <small class="text-muted">{{ __('cms.site_settings.border_color_help') }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="mt-4">
                                <h5>{{ __('cms.site_settings.theme_preview') }}</h5>
                                <div class="theme-preview-box" id="theme-preview">
                                    <div class="preview-header" style="background: var(--preview-primary, #000000); color: white; padding: 15px;">
                                        <h6 class="m-0">{{ __('cms.site_settings.preview_header') }}</h6>
                                    </div>
                                    <div class="preview-content" style="background: var(--preview-bg, #ffffff); padding: 20px;">
                                        <div class="preview-card" style="background: var(--preview-card, #f5f5f5); padding: 15px; border-radius: 8px; border: 1px solid var(--preview-border, #bbbbbb);">
                                            <h6 style="color: var(--preview-text, #111111);">Sample Card</h6>
                                            <p style="color: var(--preview-text, #111111); margin: 0;">This is how your theme will look.</p>
                                            <button class="btn btn-sm mt-2" style="background: var(--preview-primary, #000000); color: white; border: none;">Button</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="button" class="btn btn-success" id="theme-submit-btn">
                                <i class="fas fa-save me-2"></i>{{ __('cms.site_settings.update_theme') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button for General/Contact/SEO/Branding Tabs -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>{{ __('cms.site_settings.update_settings') }}
                    </button>
                    <a href="{{ route('admin.site-settings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>{{ __('cms.sidebar.cancel') }}
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('js')
<script>
// Preview Logo
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Preview Favicon
function previewFavicon(input) {
    const preview = document.getElementById('faviconPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Theme customization functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎨 Page loaded, waiting for Theme tab...');

    // Function to initialize theme tab functionality
    function initializeThemeTab() {
        console.log('🎨 Initializing Theme tab functionality...');

        // Get elements
        const themeTabPane = document.getElementById('theme');
        const customToggle = document.getElementById('theme_custom_enabled');
        const customSection = document.getElementById('custom-colors-section');
        let themeForm = document.getElementById('theme-form');

        // If form not found by ID, try querying within the tab pane
        if (!themeForm && themeTabPane) {
            themeForm = themeTabPane.querySelector('form');
            console.log('Form found via querySelector:', !!themeForm);
        }

        const submitBtn = document.getElementById('theme-submit-btn');
        const presetColors = @json(config('theme.presets'));

        console.log('Theme elements found:', {
            customToggle: !!customToggle,
            customSection: !!customSection,
            themeForm: !!themeForm,
            submitBtn: !!submitBtn,
            presetColors: Object.keys(presetColors)
        });

        // Handle theme form submission via button click
        if (submitBtn && themeForm) {
            submitBtn.addEventListener('click', function(e) {
                console.log('🔘 Theme submit button clicked!');

                // Collect form data
                const formData = new FormData();
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                formData.append('_token', csrfToken);

                // Add all inputs within theme-form
                const inputs = themeForm.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        if (input.checked) {
                            formData.append(input.name, input.value);
                        }
                    } else if (input.type === 'radio') {
                        if (input.checked) {
                            formData.append(input.name, input.value);
                        }
                    } else if (input.name && input.name !== '_token') {
                        formData.append(input.name, input.value);
                    }
                });

                console.log('📤 Submitting theme data:');
                for (let [key, value] of formData.entries()) {
                    console.log(`  ${key}: ${value}`);
                }

                // Submit via fetch
                const actionUrl = themeForm.getAttribute('data-action');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

                fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('✅ Theme saved successfully:', data);

                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>Theme settings updated successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    themeForm.insertBefore(alertDiv, themeForm.firstChild);

                    // Reload page to show changes
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    console.error('❌ Error saving theme:', error);

                    // Show error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i>Error saving theme settings. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    themeForm.insertBefore(alertDiv, themeForm.firstChild);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>{{ __("cms.site_settings.update_theme") }}';
                });
            });
            console.log('✅ Theme submit button listener attached');
        } else {
            console.error('❌ Theme form or submit button not found!', {form: !!themeForm, btn: !!submitBtn});
        }

    // Toggle custom colors section
    if (customToggle && customSection) {
        customToggle.addEventListener('change', function() {
            const isChecked = this.checked;
            console.log('Toggle changed:', isChecked);
            customSection.style.display = isChecked ? 'block' : 'none';
            setTimeout(() => updatePreview(), 100);
        });
    }

    // Sync color picker with text input
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        colorInput.addEventListener('input', function() {
            const textInput = this.nextElementSibling;
            if (textInput && textInput.classList.contains('color-text-input')) {
                textInput.value = this.value;
            }
            setTimeout(() => updatePreview(), 100);
        });
    });

    // Update preview when preset changes
    document.querySelectorAll('.theme-preset-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            console.log('Preset changed to:', this.value);
            if (this.checked) {
                const selectedPreset = presetColors[this.value];
                console.log('Selected preset colors:', selectedPreset);
                updatePreviewWithColors(selectedPreset);
            }
        });
    });

    // Update preview function
    function updatePreview() {
        const customEnabled = customToggle && customToggle.checked;
        console.log('Updating preview, custom enabled:', customEnabled);

        if (customEnabled) {
            const colors = {
                primary: document.getElementById('theme_primary_color')?.value || '#000000',
                primary_light: document.getElementById('theme_primary_light_color')?.value || '#777777',
                secondary: document.getElementById('theme_secondary_color')?.value || '#333333',
                background: document.getElementById('theme_background_color')?.value || '#ffffff',
                card_bg: document.getElementById('theme_card_background_color')?.value || '#f5f5f5',
                text: document.getElementById('theme_text_color')?.value || '#111111',
                border: document.getElementById('theme_border_color')?.value || '#bbbbbb',
            };
            console.log('Custom colors:', colors);
            updatePreviewWithColors(colors);
        } else {
            // Get selected preset
            const selectedPreset = document.querySelector('.theme-preset-radio:checked');
            if (selectedPreset) {
                const colors = presetColors[selectedPreset.value];
                console.log('Using preset:', selectedPreset.value, colors);
                updatePreviewWithColors(colors);
            }
        }
    }

    function updatePreviewWithColors(colors) {
        const preview = document.getElementById('theme-preview');
        console.log('Updating preview with colors:', colors, 'Preview element:', !!preview);
        if (preview && colors) {
            preview.style.setProperty('--preview-primary', colors.primary);
            preview.style.setProperty('--preview-bg', colors.background);
            preview.style.setProperty('--preview-card', colors.card_bg);
            preview.style.setProperty('--preview-text', colors.text);
            preview.style.setProperty('--preview-border', colors.border);
            console.log('Preview updated successfully');
        }
    }

    // Initialize preview on load
    setTimeout(() => {
        console.log('Initializing preview...');
        updatePreview();
    }, 500);
    }  // End of initializeThemeTab function

    // Wait for Theme tab to be shown, then initialize
    const themeTab = document.getElementById('theme-tab');
    if (themeTab) {
        // Initialize when tab is shown
        themeTab.addEventListener('shown.bs.tab', function (event) {
            console.log('🎨 Theme tab shown!');
            initializeThemeTab();
        });

        // Also initialize immediately if tab is already active
        if (themeTab.classList.contains('active')) {
            console.log('🎨 Theme tab already active');
            initializeThemeTab();
        }
    } else {
        console.warn('⚠️  Theme tab button not found, trying to initialize anyway...');
        // Try initializing anyway (in case tab structure is different)
        setTimeout(initializeThemeTab, 100);
    }
});
</script>
@endsection
