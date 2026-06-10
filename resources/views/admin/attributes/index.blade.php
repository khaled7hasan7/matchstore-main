@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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

        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .attribute-name {
            font-weight: 500;
            color: #212529;
        }

        .attribute-values {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .value-badge {
            background: #e7f3ff;
            color: #0066cc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn.edit-btn {
            background: #fff3cd;
            border: 1px solid #ffc107;
        }

        .action-btn.edit-btn:hover {
            background: #ffc107;
        }

        .action-btn.edit-btn i {
            color: #664d03;
        }

        .action-btn.delete-btn {
            background: #f8d7da;
            border: 1px solid #dc3545;
        }

        .action-btn.delete-btn:hover {
            background: #dc3545;
        }

        .action-btn.delete-btn i {
            color: #842029;
        }

        .action-btn.delete-btn:hover i {
            color: #fff;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.attributes.title_manage') }}</h2>
                <p class="page-subtitle">{{ __('cms.attributes.manage_subtitle') ?? 'Manage product attributes and their values' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.attributes.add_attribute') ?? 'Add Attribute' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Attributes Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="attributes-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.attributes.id') }}</th>
                            <th>{{ __('cms.attributes.name') }}</th>
                            <th>{{ __('cms.attributes.values') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.attributes.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteAttributeModal" tabindex="-1" aria-labelledby="deleteAttributeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteAttributeModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.attributes.confirm_delete') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('cms.attributes.delete_confirmation') }}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.attributes.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAttribute">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.attributes.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

@php
    $datatableLang = __('cms.datatables');
@endphp

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.attributes.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $('#attributes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.attributes.data') }}",
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        return `<span class="attribute-name">${data}</span>`;
                    }
                },
                {
                    data: 'values',
                    name: 'values',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (data && data.length > 0) {
                            let badges = data.map(value => `<span class="value-badge">${value}</span>`);
                            return `<div class="attribute-values">${badges.join('')}</div>`;
                        }
                        return '<span class="text-muted">No values</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<div class="action-btns">
                                    <a href="/admin/attributes/${row.id}/edit" class="action-btn edit-btn" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <span class="action-btn delete-btn" onclick="deleteAttribute(${row.id})" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </span>
                                </div>`;
                    }
                }
            ],
            pageLength: 10,
            language: @json($datatableLang),
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
        });
    });

    let attributeToDeleteId = null;

    function deleteAttribute(id) {
        attributeToDeleteId = id;
        $('#deleteAttributeModal').modal('show');

        $('#confirmDeleteAttribute').off('click').on('click', function() {
            if (attributeToDeleteId !== null) {
                $.ajax({
                    url: '{{ route('admin.attributes.destroy', ':id') }}'.replace(':id', attributeToDeleteId),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#attributes-table').DataTable().ajax.reload();
                            toastr.success(response.message, "{{ __('cms.attributes.success') }}", {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                timeOut: 5000
                            });
                            $('#deleteAttributeModal').modal('hide');
                        } else {
                            toastr.error(response.message, "Error", {
                                closeButton: true,
                                progressBar: true,
                                positionClass: "toast-top-right",
                                timeOut: 5000
                            });
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Error deleting attribute! Please try again.", "Error", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteAttributeModal').modal('hide');
                    }
                });
            }
        });
    }
</script>

@endsection
