{{-- Data Table Card Component --}}
{{-- Usage: @include('admin.components.data-table-card', ['title' => 'Optional Title', 'tableId' => 'my-table']) --}}

<div class="card shadow-sm border-0">
    @if(isset($title))
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>

<style>
    .card {
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 0.75rem;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
