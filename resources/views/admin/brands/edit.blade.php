@extends('admin.layouts.admin')

@section('css')
    <style>
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
            padding: 0.625rem 0.875rem;
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link:hover {
            border: none;
            color: #0d6efd;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border: none;
            border-bottom: 2px solid #0d6efd;
            background: transparent;
        }

        .btn-primary {
            padding: 0.625rem 1.5rem;
            font-weight: 500;
            border-radius: 0.375rem;
        }

        .btn-secondary {
            padding: 0.625rem 1.5rem;
            font-weight: 500;
            border-radius: 0.375rem;
        }

        .custom-file label.btn {
            margin-bottom: 0;
        }

        .img-thumbnail {
            border-radius: 0.375rem;
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .alert {
            border-radius: 0.375rem;
            border-left: 4px solid;
        }

        .alert-danger {
            border-left-color: #dc3545;
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.brands.update') ?? 'Edit Brand' }}</h2>
                <p class="page-subtitle">{{ __('cms.brands.edit_subtitle') ?? 'Update brand information' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.brands.back') ?? 'Back to Brands' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Edit Form Card --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ __('cms.brands.brand_info') ?? 'Brand Information' }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($brand))
                    @method('PUT')
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>{{ __('cms.brands.error_title') ?? 'Whoops! There were some problems with your input.' }}</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Language Tabs --}}
                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                    @foreach($activeLanguages as $language)
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

                <div class="tab-content mt-4" id="languageTabContent">
                    @foreach($activeLanguages as $language)
                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                             id="{{ $language->name }}"
                             role="tabpanel">

                            {{-- Brand Name --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.brands.name') }} ({{ $language->code }})</label>
                                <input type="text"
                                       name="translations[{{ $language->code }}][name]"
                                       class="form-control @error("translations.{$language->code}.name") is-invalid @enderror"
                                       value="{{ old('translations.'.$language->code.'.name', $brand->translations->firstWhere('locale', $language->code)->name ?? '') }}"
                                       placeholder="{{ __('cms.brands.name_placeholder') ?? 'Enter brand name' }}">
                                @error("translations.{$language->code}.name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">{{ __('cms.brands.description') }} ({{ $language->code }})</label>
                                <textarea name="translations[{{ $language->code }}][description]"
                                          class="form-control ck-editor-multi-languages @error("translations.{$language->code}.description") is-invalid @enderror"
                                          rows="4"
                                          placeholder="{{ __('cms.brands.description_placeholder') ?? 'Enter brand description' }}">{{ old('translations.'.$language->code.'.description', $brand->translations->firstWhere('locale', $language->code)->description ?? '') }}</textarea>
                                @error("translations.{$language->code}.description")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Brand Logo --}}
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">{{ __('cms.brands.logo') }}</label>
                            <div class="custom-file">
                                <label class="btn btn-primary" for="logo_file">
                                    <i class="bi bi-upload me-2"></i>{{ __('cms.brands.choose_file') }}
                                </label>
                                <input type="file"
                                       name="logo_url"
                                       accept="image/*"
                                       class="form-control d-none @error('logo_url') is-invalid @enderror"
                                       id="logo_file">
                            </div>

                            {{-- Current Logo / Preview --}}
                            @if(isset($brand) && $brand->logo_url)
                                <div class="mt-3" id="logo_preview">
                                    <p class="text-muted small mb-2">{{ __('cms.brands.current_logo') ?? 'Current Logo:' }}</p>
                                    <img id="logo_preview_img"
                                         src="{{ asset('storage/'.$brand->logo_url) }}"
                                         alt="Brand Logo"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                            @else
                                <div class="mt-3" id="logo_preview" style="display:none;">
                                    <img id="logo_preview_img"
                                         src=""
                                         alt="Brand Logo Preview"
                                         class="img-thumbnail"
                                         style="max-width: 200px;">
                                </div>
                            @endif

                            @error('logo_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ isset($brand) ? __('cms.brands.update') : __('cms.brands.create') }}
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                        {{ __('cms.brands.cancel') ?? 'Cancel' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
{{-- Logo Preview --}}
<script>
    document.getElementById('logo_file').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var previewElement = document.getElementById('logo_preview');
        var previewImage = document.getElementById('logo_preview_img');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewElement.style.display = 'block';
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            @if(isset($brand) && $brand->logo_url)
                previewElement.style.display = 'block';
                previewImage.src = "{{ asset('storage/'.$brand->logo_url) }}";
            @else
                previewElement.style.display = 'none';
            @endif
        }
    });
</script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('.ck-editor-multi-languages').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection
