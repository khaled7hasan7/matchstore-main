<!-- resources/views/admin/site-settings/index.blade.php -->

@extends('admin.layouts.admin')

@section('css')
<style>
    .settings-header {
        background: white;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid #e0e0e0;
    }

    .settings-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d2d2d;
        margin: 0 0 0.5rem 0;
    }

    .settings-header p {
        color: #6c757d;
        margin: 0;
        font-size: 0.95rem;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .setting-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .setting-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #595959;
        transition: width 0.3s ease;
    }

    .setting-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    .setting-card:hover::before {
        width: 6px;
    }

    .setting-icon {
        width: 55px;
        height: 55px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: #595959;
        color: white;
    }

    .setting-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .setting-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #2d2d2d;
        word-break: break-word;
    }

    .setting-value.not-set {
        color: #6c757d;
        font-style: italic;
        font-weight: 400;
    }

    .btn-edit-settings {
        background: #0d6efd;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.375rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-edit-settings:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        color: white;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        border: 1px solid #e0e0e0;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    .stat-number {
        font-size: 1.875rem;
        font-weight: 700;
        color: #2d2d2d;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .settings-header {
            padding: 1.5rem;
        }

        .settings-header h1 {
            font-size: 1.5rem;
        }

        .settings-grid {
            grid-template-columns: 1fr;
        }

        .quick-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    {{-- Header Section --}}
    <div class="settings-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1><i class="fas fa-cog me-2"></i>{{ __('cms.site_settings.title') }}</h1>
                <p>Manage your store's general settings and configuration</p>
            </div>
            <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-edit-settings mt-3 mt-md-0">
                <i class="fas fa-edit me-2"></i>{{ __('cms.site_settings.edit_settings') }}
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Quick Stats --}}
    <div class="quick-stats">
        <div class="stat-card">
            <div class="stat-number">5</div>
            <div class="stat-label">Total Settings</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $settings && $settings->site_name ? '✓' : '✗' }}</div>
            <div class="stat-label">Site Name</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $settings && $settings->meta_title ? '✓' : '✗' }}</div>
            <div class="stat-label">SEO Configured</div>
        </div>
    </div>

    {{-- Settings Grid --}}
    <div class="settings-grid">
        {{-- Site Name --}}
        <div class="setting-card">
            <div class="setting-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="setting-label">{{ __('cms.site_settings.site_name') }}</div>
            <div class="setting-value {{ $settings && $settings->site_name ? '' : 'not-set' }}">
                {{ $settings->site_name ?? __('cms.site_settings.not_set') }}
            </div>
        </div>

        {{-- Tagline --}}
        <div class="setting-card">
            <div class="setting-icon">
                <i class="fas fa-tag"></i>
            </div>
            <div class="setting-label">{{ __('cms.site_settings.tagline') }}</div>
            <div class="setting-value {{ $settings && $settings->tagline ? '' : 'not-set' }}">
                {{ $settings->tagline ?? __('cms.site_settings.not_set') }}
            </div>
        </div>

        {{-- Meta Title --}}
        <div class="setting-card">
            <div class="setting-icon">
                <i class="fas fa-heading"></i>
            </div>
            <div class="setting-label">{{ __('cms.site_settings.meta_title') }}</div>
            <div class="setting-value {{ $settings && $settings->meta_title ? '' : 'not-set' }}">
                {{ $settings->meta_title ?? __('cms.site_settings.not_set') }}
            </div>
        </div>

        {{-- Meta Description --}}
        <div class="setting-card">
            <div class="setting-icon">
                <i class="fas fa-align-left"></i>
            </div>
            <div class="setting-label">{{ __('cms.site_settings.meta_description') }}</div>
            <div class="setting-value {{ $settings && $settings->meta_description ? '' : 'not-set' }}">
                {{ $settings->meta_description ?? __('cms.site_settings.not_set') }}
            </div>
        </div>

        {{-- Meta Keywords --}}
        <div class="setting-card">
            <div class="setting-icon">
                <i class="fas fa-key"></i>
            </div>
            <div class="setting-label">{{ __('cms.site_settings.meta_keywords') }}</div>
            <div class="setting-value {{ $settings && $settings->meta_keywords ? '' : 'not-set' }}">
                {{ $settings->meta_keywords ?? __('cms.site_settings.not_set') }}
            </div>
        </div>
    </div>
@endsection
