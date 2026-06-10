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

        /* Table Styling */
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

        /* Customer Info */
        .customer-name {
            font-weight: 500;
            color: #212529;
        }

        .customer-email {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .customer-phone {
            color: #495057;
            font-size: 0.875rem;
        }

        .customer-address {
            color: #6c757d;
            font-size: 0.875rem;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.active {
            background: #d1e7dd;
            color: #0a3622;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #842029;
        }

        /* Action Buttons */
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
                <h2 class="page-title">{{ __('cms.customers.customer_list') }}</h2>
                <p class="page-subtitle">{{ __('cms.customers.subtitle') ?? 'View and manage customer accounts' }}</p>
            </div>
        </div>
    </div>

    {{-- Customers Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="customers-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.customers.id') }}</th>
                            <th>{{ __('cms.customers.name') }}</th>
                            <th>{{ __('cms.customers.email') }}</th>
                            <th style="width: 140px;">{{ __('cms.customers.phone') }}</th>
                            <th style="width: 200px;">{{ __('cms.customers.address') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.customers.status') }}</th>
                            <th class="text-center" style="width: 80px;">{{ __('cms.customers.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteCustomerModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.customers.confirm_delete_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('cms.customers.confirm_delete_message') }}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('cms.customers.cancel_button') }}
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCustomer">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.customers.delete_button') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.customers.success_title') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.customers.data') }}",
            type: "GET"
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    return `<span class="customer-name">${data}</span>`;
                }
            },
            {
                data: 'email',
                name: 'email',
                render: function(data, type, row) {
                    return `<span class="customer-email">${data}</span>`;
                }
            },
            {
                data: 'phone',
                name: 'phone',
                render: function(data, type, row) {
                    return data ? `<span class="customer-phone">${data}</span>` : '-';
                }
            },
            {
                data: 'address',
                name: 'address',
                render: function(data, type, row) {
                    if (data) {
                        return `<span class="customer-address" title="${data}">${data}</span>`;
                    }
                    return '-';
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data) {
                    const statusClass = data === 'active' ? 'active' : 'inactive';
                    const statusText = data === 'active' ? 'Active' : 'Inactive';
                    return `<span class="status-badge ${statusClass}">${statusText}</span>`;
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <span class="action-btn delete-btn" onclick="deleteCustomer(${row.id})" title="Delete">
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

let customerToDeleteId = null;

function deleteCustomer(id) {
    customerToDeleteId = id;
    $('#deleteCustomerModal').modal('show');

    $('#confirmDeleteCustomer').off('click').on('click', function() {
        if (customerToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.customers.destroy', ':id') }}'.replace(':id', customerToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#customers-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.customers.success_title') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteCustomerModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error("Error deleting customer!", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteCustomerModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
