@extends('themes.xylo.layouts.master')

@section('title', $translation->title ?? 'Page')

@section('content')
<div class="page-wrapper">
    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('xylo.home') }}">{{ __('store.common.home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $translation->title }}
                </li>
            </ol>
        </nav>

        {{-- Page Title --}}
        <h1 class="page-title mb-4">{{ $translation->title }}</h1>

        {{-- Page Featured Image (if exists) --}}
        @if($page->image_url)
            <div class="page-featured-image mb-4">
                @php
                    $finalPageUrl = store_image($page->image_url);
                @endphp
                <img src="{{ $finalPageUrl }}"
                     alt="{{ $translation->title }}"
                     class="img-fluid rounded">
            </div>
        @endif

        {{-- Page Content --}}
        <div class="page-content">
            {!! $translation->content !!}
        </div>

        {{-- Page Meta Info --}}
        @if($page->created_at)
            <div class="page-meta mt-5 pt-4 border-top text-muted">
                <small>
                    {{ __('Last updated') }}: {{ $page->updated_at->format('F d, Y') }}
                </small>
            </div>
        @endif
    </div>
</div>

<style>
    .page-wrapper {
        min-height: 60vh;
        background-color: var(--light-color);
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-item a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--accent-color);
    }

    .breadcrumb-item.active {
        color: var(--dark-color);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: var(--text-muted);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
    }

    .page-featured-image {
        max-width: 100%;
        overflow: hidden;
        border-radius: 0.5rem;
    }

    .page-featured-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 400px;
    }

    .page-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--dark-color);
    }

    .page-content h2 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .page-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: var(--primary-color);
    }

    .page-content p {
        margin-bottom: 1.25rem;
    }

    .page-content ul,
    .page-content ol {
        margin-bottom: 1.25rem;
        padding-left: 2rem;
    }

    .page-content li {
        margin-bottom: 0.5rem;
    }

    .page-content a {
        color: var(--accent-color);
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: border-color 0.2s ease;
    }

    .page-content a:hover {
        border-bottom-color: var(--accent-color);
    }

    .page-content blockquote {
        border-left: 4px solid var(--accent-color);
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: var(--text-muted);
    }

    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.375rem;
        margin: 1.5rem 0;
    }

    .page-meta {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .page-content {
            font-size: 1rem;
        }

        .page-content h2 {
            font-size: 1.5rem;
        }

        .page-content h3 {
            font-size: 1.25rem;
        }
    }
</style>
@endsection
