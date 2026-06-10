@extends('admin.layouts.admin')

@section('title', 'Edit Attribute')

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

        .value-group {
            position: relative;
        }

        .remove-value {
            width: 36px;
            height: 36px;
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link:hover {
            color: #0d6efd;
            background: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            background: transparent;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.attributes.title_edit') }}</h2>
                <p class="page-subtitle">{{ __('cms.attributes.edit_subtitle') ?? 'Update attribute details and values' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('cms.attributes.back_to_list') ?? 'Back to List' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Edit Form Card --}}
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div id="errorBar" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Attribute Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label">{{ __('cms.attributes.attribute_name') }}</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $attribute->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{ __('cms.attributes.name_placeholder') ?? 'e.g., Size, Color, Material' }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dynamic Attribute Values --}}
                <div class="mb-4">
                    <label class="form-label">{{ __('cms.attributes.attribute_values') }}</label>
                    <div id="attribute-values-container">
                        @foreach ($attribute->values as $index => $value)
                            <div class="mb-2 value-group">
                                <input type="text"
                                    name="values[]"
                                    class="form-control pe-5 @error('values.' . $index) is-invalid @enderror"
                                    value="{{ old('values.' . $index, $value->value) }}"
                                    placeholder="Enter value {{ $index }}">
                                <button type="button"
                                    class="btn btn-light rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center remove-value"
                                    title="{{ __('cms.attributes.remove_value') }}">
                                    <i class="fa-solid fa-circle-xmark text-danger fs-6"></i>
                                </button>
                                @error('values.' . $index)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-value"
                            class="btn btn-light rounded-circle shadow-sm border d-flex align-items-center justify-content-center"
                            style="width:48px; height:48px;"
                            title="{{ __('cms.attributes.add_value') ?? 'Add Value' }}">
                        <i class="fa-solid fa-plus text-primary fs-5"></i>
                    </button>
                </div>

                {{-- Translations Section --}}
                <div class="mb-4">
                    <label class="form-label">{{ __('cms.attributes.translations') }}</label>
                    <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                        @foreach ($languages as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $language->code }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#{{ $language->code }}"
                                        type="button">
                                    {{ ucwords($language->name) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mt-3" id="languageTabContent">
                        @foreach ($languages as $language)
                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}">
                                <div id="translation-container-{{ $language->code }}">
                                    @foreach ($attribute->values as $vIndex => $value)
                                        @php
                                            $translation = $value->translations->where('language_code', $language->code)->first();
                                        @endphp
                                        <div class="input-group mb-2 translation-group">
                                            <input type="text"
                                                   name="translations[{{ $language->code }}][]"
                                                   class="form-control @error('translations.' . $language->code . '.' . $vIndex) is-invalid @enderror"
                                                   value="{{ old('translations.' . $language->code . '.' . $vIndex, optional($translation)->translated_value) }}"
                                                   placeholder="Enter {{ $language->name }} value {{ $vIndex }}">
                                            @error('translations.' . $language->code . '.' . $vIndex)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>{{ __('cms.attributes.update_attribute') }}
                    </button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>{{ __('cms.attributes.cancel') ?? 'Cancel' }}
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
    let removeText = "{{ __('cms.attributes.remove_value') }}";
    let languages = @json($languages->pluck('code')->toArray());
    let languageNames = @json($languages->pluck('name')->toArray());

    function updatePlaceholders() {
        let valueGroups = document.querySelectorAll("#attribute-values-container .value-group input");
        valueGroups.forEach((input, i) => {
            input.placeholder = "Enter value " + i;
        });

        languages.forEach((lang, index) => {
            let translationInputs = document.querySelectorAll("#translation-container-" + lang + " .translation-group input");
            translationInputs.forEach((input, i) => {
                input.placeholder = "Enter " + languageNames[index] + " value " + i;
            });
        });
    }

    document.getElementById("add-value").addEventListener("click", function () {
        let container = document.getElementById("attribute-values-container");
        let newValueGroup = document.createElement("div");
        newValueGroup.classList.add("mb-2", "value-group");

        let valueInput = document.createElement("input");
        valueInput.type = "text";
        valueInput.name = "values[]";
        valueInput.classList.add("form-control", "pe-5");

        let removeValueBtn = document.createElement("button");
        removeValueBtn.type = "button";
        removeValueBtn.classList.add(
            "btn", "btn-light", "rounded-circle", "shadow-sm", "border-0",
            "d-flex", "align-items-center", "justify-content-center", "remove-value"
        );
        removeValueBtn.title = removeText;
        removeValueBtn.innerHTML = '<i class="fa-solid fa-circle-xmark text-danger fs-6"></i>';

        newValueGroup.appendChild(valueInput);
        newValueGroup.appendChild(removeValueBtn);
        container.appendChild(newValueGroup);

        languages.forEach((lang, index) => {
            let containerLang = document.getElementById("translation-container-" + lang);
            let newTranslationGroup = document.createElement("div");
            newTranslationGroup.classList.add("input-group", "mb-2", "translation-group");

            let input = document.createElement("input");
            input.type = "text";
            input.name = `translations[${lang}][]`;
            input.classList.add("form-control");

            newTranslationGroup.appendChild(input);
            containerLang.appendChild(newTranslationGroup);
        });

        updatePlaceholders();
    });

    document.addEventListener("click", function(e) {
       if (e.target.closest(".remove-value")) {
            let valueGroup = e.target.closest(".value-group");
            let index = Array.from(document.querySelectorAll("#attribute-values-container .value-group")).indexOf(valueGroup);

            if(valueGroup) valueGroup.remove();

            languages.forEach(lang => {
                let translations = document.querySelectorAll("#translation-container-" + lang + " .translation-group");
                if(translations[index]) translations[index].remove();
            });

            updatePlaceholders();
        }
    });

    updatePlaceholders();
});
</script>
@endsection
