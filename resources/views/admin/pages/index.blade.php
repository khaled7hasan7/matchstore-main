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

        .page-name {
            font-weight: 500;
            color: #212529;
        }

        /* Custom toggle switch */
        .status-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .status-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .status-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 24px;
        }

        .status-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .status-slider {
            background-color: #198754;
        }

        input:checked + .status-slider:before {
            transform: translateX(26px);
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
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.pages.title') ?? 'Pages' }}</h2>
                <p class="page-subtitle">{{ __('cms.pages.subtitle') ?? 'Manage your website pages' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.pages.add_page') ?? 'Add Page' }}
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="pagesTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('cms.pages.table_title') }}</th>
                            <th>{{ __('cms.pages.table_slug') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.pages.table_status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.pages.table_actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePageModal" tabindex="-1" aria-labelledby="deletePageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deletePageModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.pages.delete_modal_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{ __('cms.pages.delete_modal_text') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.pages.delete_modal_cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePage">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.pages.delete_modal_delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.pages.toastr_success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    const table = $('#pagesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.pages.data') }}",
            type: 'POST',
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            {
                data: 'translated_title',
                name: 'translated_title',
                render: function(data, type, row) {
                    return '<span class="page-name">' + data + '</span>';
                }
            },
            { data: 'slug', name: 'slug' },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var isChecked = data ? 'checked' : '';
                    return `<label class="status-switch">
                                <input type="checkbox" class="toggle-status" data-id="${row.id}" ${isChecked}>
                                <span class="status-slider"></span>
                            </label>`;
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
                                <a href="/admin/pages/${row.id}/edit" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deletePage(${row.id})" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </span>
                            </div>`;
                }
            }
        ],
        pageLength: 10,
        language: @json($datatableLang),
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });

    // Status toggle handler
    $(document).on('change', '.toggle-status', function() {
        var pageId = $(this).data('id');
        var isActive = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: '{{ route('admin.pages.updateStatus') }}',
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: pageId,
                status: isActive
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, "Updated", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                } else {
                    toastr.error(response.message, "Failed", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                }
            },
            error: function() {
                toastr.error('Error updating status!', 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                $(this).prop('checked', !isActive);
            }
        });
    });
});

let pageToDeleteId = null;

function deletePage(id) {
    pageToDeleteId = id;
    $('#deletePageModal').modal('show');

    $('#confirmDeletePage').off('click').on('click', function() {
        if (pageToDeleteId !== null) {
            $.ajax({
                url: '{{ route("admin.pages.destroy", ":id") }}'.replace(':id', pageToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#pagesTable').DataTable().ajax.reload();
                        toastr.success(response.message || "{{ __('cms.pages.toastr_success') }}", "{{ __('cms.pages.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deletePageModal').modal('hide');
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
                    toastr.error("{{ __('cms.pages.toastr_error') }}", 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deletePageModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
