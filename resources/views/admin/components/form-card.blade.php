{{-- Form Card Component --}}
{{-- Usage: @component('admin.components.form-card', ['title' => 'Form Title', 'icon' => 'fas fa-icon']) --}}

<div class="card shadow-sm border-0 mb-4">
    @if(isset($title))
        <div class="card-header bg-primary text-white">
            @if(isset($icon))
                <i class="{{ $icon }} me-2"></i>
            @endif
            <h6 class="d-inline mb-0">{{ $title }}</h6>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>

<style>
    .form-card .card {
        border-radius: 0.5rem;
    }

    .form-card .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding: 1rem 1.5rem;
        font-weight: 600;
    }

    .form-card .card-body {
        padding: 2rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.625rem 0.875rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
    }

    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }
</style>
