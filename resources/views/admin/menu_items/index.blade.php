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

        .menu-item-name {
            font-weight: 500;
            color: #212529;
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
                <h2 class="page-title">{{ __('cms.menu_items.heading') }}</h2>
                <p class="page-subtitle">{{ __('cms.menu_items.subtitle') ?? 'Manage menu items and navigation' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.menus.items.create', $menu?->id) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.menu_items.add_new') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Menu Items Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="menu-items-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.menu_items.id') }}</th>
                            <th>{{ __('cms.menu_items.slug') }}</th>
                            <th style="width: 120px;">{{ __('cms.menu_items.order_number') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.menu_items.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteMenuItemModal" tabindex="-1" aria-labelledby="deleteMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteMenuItemModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.menu_items.massage_confirm') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('cms.menu_items.confirm_delete') }}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.menu_items.massage_cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteMenuItem">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.menu_items.massage_delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.menu_items.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    var menuId = {{ $menu?->id ?? 'null' }};
    $('#menu-items-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.menus.item.getData') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            error: function(xhr, error, thrown) {
                console.log("AJAX Error:", xhr.responseText);
                alert("DataTables AJAX Error: Check console for details.");
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            {
                data: 'slug',
                name: 'slug',
                render: function(data, type, row) {
                    return '<span class="menu-item-name">' + data + '</span>';
                }
            },
            { data: 'order_number', name: 'order_number' },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <a href="/admin/items/${row.id}/edit" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deleteMenuItem(${row.id})" title="Delete">
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

let menuItemToDeleteId = null;

function deleteMenuItem(id) {
    menuItemToDeleteId = id;
    $('#deleteMenuItemModal').modal('show');

    $('#confirmDeleteMenuItem').off('click').on('click', function() {
        if (menuItemToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.items.destroy', ':id') }}'.replace(':id', menuItemToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#menu-items-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.menu_items.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteMenuItemModal').modal('hide');
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
                    toastr.error("Error deleting menu item! Please try again.", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteMenuItemModal').modal('hide');
                }
            });
        }
    });
}

</script>
@endsection
