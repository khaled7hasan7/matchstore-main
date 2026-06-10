@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.promo_cards.edit_promo_card') }}</h2>
                <p class="page-subtitle">{{ __('cms.promo_cards.edit_subtitle') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.promo-cards.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.promo_cards.back_to_list') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Edit Form Card --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.promo-cards.update', $promoCard->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Size --}}
                <div class="mb-4">
                    <label for="size" class="form-label">{{ __('cms.promo_cards.size') }} <span class="text-danger">*</span></label>
                    <select name="size" id="size" class="form-select @error('size') is-invalid @enderror" required>
                        <option value="large" {{ old('size', $promoCard->size) === 'large' ? 'selected' : '' }}>{{ __('cms.promo_cards.size_large') }}</option>
                        <option value="small" {{ old('size', $promoCard->size) === 'small' ? 'selected' : '' }}>{{ __('cms.promo_cards.size_small') }}</option>
                    </select>
                    @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Order --}}
                <div class="mb-4">
                    <label for="order" class="form-label">{{ __('cms.promo_cards.order') }} <span class="text-danger">*</span></label>
                    <input type="number" name="order" id="order"
                           class="form-control @error('order') is-invalid @enderror"
                           value="{{ old('order', $promoCard->order) }}"
                           min="0" required>
                    <small class="form-text text-muted">{{ __('cms.promo_cards.order_help') }}</small>
                    @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="form-label">{{ __('cms.promo_cards.status') }}</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="1" {{ old('status', $promoCard->status) == 1 ? 'selected' : '' }}>{{ __('cms.promo_cards.active') }}</option>
                        <option value="0" {{ old('status', $promoCard->status) == 0 ? 'selected' : '' }}>{{ __('cms.promo_cards.inactive') }}</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Language tabs --}}
                <hr class="my-4">
                <h5 class="mb-3">{{ __('cms.promo_cards.translations') }}</h5>

                <ul class="nav nav-tabs" role="tablist">
                    @foreach($languages as $language)
                        <li class="nav-item">
                            <button type="button"
                                    class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $language->code }}">
                                {{ ucwords($language->name) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3">
                    @foreach($languages as $language)
                        @php
                            $translation = $translations->get($language->code);
                        @endphp
                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}">

                            {{-- Badge Text --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.promo_cards.badge_text') }} ({{ $language->code }})</label>
                                <input type="text"
                                       name="languages[{{ $language->code }}][badge_text]"
                                       class="form-control @error('languages.' . $language->code . '.badge_text') is-invalid @enderror"
                                       value="{{ old('languages.' . $language->code . '.badge_text', $translation->badge_text ?? '') }}"
                                       placeholder="e.g., Summer Sale, New Arrival">
                                <small class="form-text text-muted">{{ __('cms.promo_cards.badge_text_help') }}</small>
                                @error('languages.' . $language->code . '.badge_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    {{ __('cms.promo_cards.title') }} ({{ $language->code }})
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="languages[{{ $language->code }}][title]"
                                       class="form-control @error('languages.' . $language->code . '.title') is-invalid @enderror"
                                       value="{{ old('languages.' . $language->code . '.title', $translation->title ?? '') }}"
                                       required
                                       placeholder="e.g., Up to 50% Off">
                                @error('languages.' . $language->code . '.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Button Text --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.promo_cards.button_text') }} ({{ $language->code }})</label>
                                <input type="text"
                                       name="languages[{{ $language->code }}][button_text]"
                                       class="form-control @error('languages.' . $language->code . '.button_text') is-invalid @enderror"
                                       value="{{ old('languages.' . $language->code . '.button_text', $translation->button_text ?? '') }}"
                                       placeholder="e.g., Shop Now, Discover">
                                @error('languages.' . $language->code . '.button_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Button URL --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.promo_cards.button_url') }} ({{ $language->code }})</label>
                                <input type="text"
                                       name="languages[{{ $language->code }}][button_url]"
                                       class="form-control @error('languages.' . $language->code . '.button_url') is-invalid @enderror"
                                       value="{{ old('languages.' . $language->code . '.button_url', $translation->button_url ?? '') }}"
                                       placeholder="/shop">
                                <small class="form-text text-muted">{{ __('cms.promo_cards.button_url_help') }}</small>
                                @error('languages.' . $language->code . '.button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image URL --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.promo_cards.image_url') }} ({{ $language->code }})</label>
                                <input type="url"
                                       name="languages[{{ $language->code }}][image_url]"
                                       class="form-control @error('languages.' . $language->code . '.image_url') is-invalid @enderror"
                                       value="{{ old('languages.' . $language->code . '.image_url', $translation->image_url ?? '') }}"
                                       placeholder="https://example.com/image.jpg">
                                <small class="form-text text-muted">{{ __('cms.promo_cards.image_url_help') }}</small>
                                @error('languages.' . $language->code . '.image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Image Preview --}}
                                @if($translation && $translation->image_url)
                                    <div class="mt-2">
                                        <img src="{{ $translation->image_url }}" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Submit Button --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.promo_cards.update') }}
                    </button>
                    <a href="{{ route('admin.promo-cards.index') }}" class="btn btn-secondary">
                        {{ __('cms.promo_cards.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    @if ($errors->any())
        var firstErrorElement = document.querySelector('.is-invalid');
        if (firstErrorElement) {
            var tabPane = firstErrorElement.closest('.tab-pane');
            if (tabPane) {
                var tabId = tabPane.getAttribute('id');
                var triggerEl = document.querySelector(`button[data-bs-target="#${tabId}"]`);
                if (triggerEl) {
                    var tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }
        }
    @endif
});
</script>
@endsection
