@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.banners.edit_banner') }}</h2>
                <p class="page-subtitle">{{ __('cms.banners.edit_subtitle') ?? 'Update banner information' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.banners.back_to_list') ?? 'Back to List' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Edit Form Card --}}
    <div class="card">
        <div class="card-body">
            <form id="bannerForm" action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Banner type --}}
                <div class="mb-4">
                    <label for="type" class="form-label">{{ __('cms.banners.banner_type') }}</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="promotion" {{ $banner->type == 'promotion' ? 'selected' : '' }}>{{ __('cms.banners.promotion') }}</option>
                        <option value="sale" {{ $banner->type == 'sale' ? 'selected' : '' }}>{{ __('cms.banners.sale') }}</option>
                        <option value="seasonal" {{ $banner->type == 'seasonal' ? 'selected' : '' }}>{{ __('cms.banners.seasonal') }}</option>
                        <option value="featured" {{ $banner->type == 'featured' ? 'selected' : '' }}>{{ __('cms.banners.featured') }}</option>
                        <option value="announcement" {{ $banner->type == 'announcement' ? 'selected' : '' }}>{{ __('cms.banners.announcement') }}</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Language Tabs --}}
                @if(!empty($languages) && count($languages) > 0)
                    <ul class="nav nav-tabs mt-4" id="languageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $language->name }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#{{ $language->name }}"
                                        type="button"
                                        role="tab">
                                    {{ ucwords($language->name) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mt-3" id="languageTabContent">
                        @foreach($languages as $index => $language)
                            @php
                                $bannerTranslation = $translations[$language->code] ?? new stdClass();
                            @endphp
                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                                 id="{{ $language->name }}"
                                 role="tabpanel">

                                {{-- Title --}}
                                <div class="mb-3">
                                    <label for="languages[{{ $index }}][title]" class="form-label">{{ __('cms.banners.title') }} ({{ $language->code }})</label>
                                    <input type="text"
                                           name="languages[{{ $index }}][title]"
                                           class="form-control @error('languages.' . $index . '.title') is-invalid @enderror"
                                           value="{{ old('languages.' . $index . '.title', $bannerTranslation->title ?? '') }}"
                                           required>
                                    @error('languages.' . $index . '.title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label for="languages[{{ $index }}][description]" class="form-label">{{ __('cms.banners.description') }} ({{ $language->code }})</label>
                                    <textarea id="description_{{ $index }}"
                                              name="languages[{{ $index }}][description]"
                                              class="form-control ck-editor-multi-languages @error('languages.' . $index . '.description') is-invalid @enderror"
                                              rows="3">{{ old('languages.' . $index . '.description', $bannerTranslation->description ?? '') }}</textarea>
                                    @error('languages.' . $index . '.description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Image --}}
                                <div class="mb-3">
                                    <label class="form-label">{{ __('cms.banners.image') }} ({{ $language->code }})</label>
                                    <div class="mb-2">
                                        <label for="image_file_{{ $language->code }}" class="btn btn-primary">
                                            <i class="bi bi-upload me-2"></i>{{ __('cms.banners.choose_file') }}
                                        </label>
                                        <input type="file"
                                               id="image_file_{{ $language->code }}"
                                               name="languages[{{ $index }}][image]"
                                               class="d-none form-control @error('languages.' . $index . '.image') is-invalid @enderror"
                                               accept="image/*"
                                               onchange="updateFileName(this, '{{ $language->code }}'); previewImage(this, '{{ $language->code }}')">

                                        <span id="file-name-{{ $language->code }}" class="ms-2 text-muted">
                                            @if (!empty($bannerTranslation->image))
                                                {{ basename($bannerTranslation->image) }}
                                            @endif
                                        </span>
                                    </div>

                                    @error('languages.' . $index . '.image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    {{-- Image Preview --}}
                                    <div id="image_preview_{{ $language->code }}" class="mt-3">
                                        <img id="image_preview_img_{{ $language->code }}"
                                             src="{{ !empty($bannerTranslation->image_url) ? Storage::url($bannerTranslation->image_url) : asset('images/placeholder.png') }}"
                                             alt="{{ __('cms.banners.image_preview') }}"
                                             class="img-thumbnail"
                                             style="max-width: 300px; border-radius: 0.5rem;">
                                    </div>

                                    <input type="hidden" name="languages[{{ $index }}][language_code]" value="{{ $language->code }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-danger mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ __('cms.banners.no_languages_available') }}
                    </div>
                @endif

                {{-- Submit Buttons --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.banners.save') }}
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                        {{ __('cms.banners.button_back') ?? 'Cancel' }}
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

<script>
function updateFileName(input, langCode) {
    let fileNameSpan = document.getElementById('file-name-' + langCode);
    fileNameSpan.textContent = input.files.length > 0 ? input.files[0].name : '{{ __("cms.banners.no_file_chosen") }}';
}

function previewImage(input, langCode) {
    let previewImg = document.getElementById('image_preview_img_' + langCode);
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const editors = {};

    document.querySelectorAll('.ck-editor-multi-languages').forEach((el) => {
        const id = el.id;

        ClassicEditor.create(el)
            .then(editor => {
                editors[id] = editor;
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
    });

    document.getElementById('bannerForm').addEventListener('submit', function () {
        for (const id in editors) {
            const editor = editors[id];
            if (editor) {
                const textarea = document.getElementById(id);
                if (textarea) textarea.value = editor.getData();
            }
        }
    });
});
</script>
@endsection
