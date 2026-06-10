@extends('admin.layouts.admin')

@section('title', __('cms.shipping_zones.title'))

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

        .zone-name {
            font-weight: 500;
            color: #212529;
        }

        .cost-badge {
            background: #e7f3ff;
            color: #0066cc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .countries-list {
            color: #6c757d;
            font-size: 0.875rem;
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
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.shipping_zones.title') }}</h2>
                <p class="page-subtitle">{{ __('cms.shipping_zones.subtitle') ?? 'Manage shipping zones and rates' }}</p>
            </div>
            <div>
                <a href="{{ route('shipping-zones.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.shipping_zones.add_new_zone') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Shipping Zones Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="shipping-zones-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.shipping_zones.id') }}</th>
                            <th>{{ __('cms.shipping_zones.name') }}</th>
                            <th>{{ __('cms.shipping_zones.countries') }}</th>
                            <th style="width: 120px;">{{ __('cms.shipping_zones.base_cost') }}</th>
                            <th style="width: 120px;">{{ __('cms.shipping_zones.per_kg_cost') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.shipping_zones.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.shipping_zones.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteZoneModal" tabindex="-1" aria-labelledby="deleteZoneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteZoneModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.shipping_zones.confirm_delete_title') ?? 'Confirm Delete' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('cms.shipping_zones.confirm_delete') ?? 'Are you sure you want to delete this shipping zone?' }}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.shipping_zones.cancel') ?? 'Cancel' }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteZone">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.shipping_zones.delete') ?? 'Delete' }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.shipping_zones.success') ?? 'Success' }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    var table = $('#shipping-zones-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("shipping-zones.data") }}',
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    return '<span class="zone-name">' + data + '</span>';
                }
            },
            {
                data: 'countries',
                name: 'countries',
                orderable: false,
                render: function(data, type, row) {
                    return '<span class="countries-list">' + data + '</span>';
                }
            },
            {
                data: 'base_cost',
                name: 'base_cost',
                render: function(data, type, row) {
                    return '<span class="cost-badge">$' + data + '</span>';
                }
            },
            {
                data: 'per_kg_cost',
                name: 'per_kg_cost',
                render: function(data, type, row) {
                    return '<span class="cost-badge">$' + data + '</span>';
                }
            },
            {
                data: 'status',
                name: 'is_active',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    var isChecked = data ? 'checked' : '';
                    return `<label class="status-switch">
                                <input type="checkbox" class="status-toggle" data-id="${row.id}" ${isChecked}>
                                <span class="status-slider"></span>
                            </label>`;
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <a href="/admin/shipping-zones/${row.id}/edit" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deleteZone(${row.id})" title="Delete">
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

    // Toggle status
    $(document).on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var isActive = $(this).is(':checked');

        $.ajax({
            url: '{{ route("shipping-zones.toggle-status") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function(response) {
                toastr.success(response.message, "{{ __('cms.shipping_zones.success') ?? 'Success' }}", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
            },
            error: function(xhr) {
                toastr.error('{{ __("cms.shipping_zones.failed_update_status") ?? "Error updating status" }}', "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                // Revert toggle
                $(this).prop('checked', !isActive);
            }
        });
    });

    let zoneToDeleteId = null;

    window.deleteZone = function(id) {
        zoneToDeleteId = id;
        $('#deleteZoneModal').modal('show');
    }

    $('#confirmDeleteZone').on('click', function() {
        if (zoneToDeleteId !== null) {
            $.ajax({
                url: '/admin/shipping-zones/' + zoneToDeleteId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                        toastr.success(response.message, "{{ __('cms.shipping_zones.success') ?? 'Success' }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteZoneModal').modal('hide');
                        zoneToDeleteId = null;
                    } else {
                        toastr.error(response.message, "Error", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                    }
                },
                error: function() {
                    toastr.error('{{ __("cms.shipping_zones.failed_delete") ?? "Error deleting zone" }}', "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteZoneModal').modal('hide');
                }
            });
        }
    });
});
</script>
@endsection
