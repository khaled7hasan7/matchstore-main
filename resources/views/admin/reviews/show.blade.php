@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.product_reviews.review_details') }}</h2>
                <p class="page-subtitle">{{ __('cms.product_reviews.details_subtitle') ?? 'View review details' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.product_reviews.back_button') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Review Details Card --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-2">{{ __('cms.product_reviews.customer_name') }}</h6>
                    <p class="mb-0 fw-semibold">{{ optional($review->customer)->name ?? 'Guest' }}</p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-2">{{ __('cms.product_reviews.product_name') }}</h6>
                    <p class="mb-0 fw-semibold">
                        @php
                            $lang = app()->getLocale();
                            $translation = $review->product?->translations?->firstWhere('language_code', $lang);
                        @endphp
                        {{ $translation?->name ?? $review->product?->translations?->first()?->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-2">{{ __('cms.product_reviews.rating') }}</h6>
                    <div class="d-flex align-items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bi bi-star-fill text-warning me-1" style="font-size: 1.25rem;"></i>
                            @else
                                <i class="bi bi-star text-muted me-1" style="font-size: 1.25rem;"></i>
                            @endif
                        @endfor
                        <span class="ms-2 fw-bold">{{ $review->rating }} / 5</span>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h6 class="text-muted mb-2">{{ __('cms.product_reviews.status') }}</h6>
                    <div>
                        @if($review->status == 1)
                            <span class="status-badge active">Approved</span>
                        @else
                            <span class="status-badge inactive">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <h6 class="text-muted mb-2">{{ __('cms.product_reviews.review') }}</h6>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">{{ $review->review ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.product_reviews.back_button') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
