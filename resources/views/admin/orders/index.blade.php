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

        /* Custom Status Tabs */
        .status-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
            padding: 0;
        }

        .status-tabs .nav-item {
            margin-bottom: -2px;
        }

        .status-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
        }

        .status-tabs .nav-link:hover {
            color: #0d6efd;
            background: #f8f9fa;
        }

        .status-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            background: transparent;
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

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.processing {
            background: #cfe2ff;
            color: #084298;
        }

        .status-badge.completed {
            background: #d1e7dd;
            color: #0a3622;
        }

        .status-badge.cancelled {
            background: #f8d7da;
            color: #842029;
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
            text-decoration: none;
        }

        .action-btn.view-btn {
            background: #d1ecf1;
            border: 1px solid #0dcaf0;
        }

        .action-btn.view-btn:hover {
            background: #0dcaf0;
        }

        .action-btn.view-btn i {
            color: #055160;
        }

        .action-btn.view-btn:hover i {
            color: #fff;
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

        /* Customer Info */
        .customer-info {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 500;
            color: #212529;
        }

        .customer-email {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Total Price */
        .total-price {
            font-weight: 600;
            color: #198754;
            font-size: 1rem;
        }

        /* Order Date */
        .order-date {
            color: #6c757d;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.orders.title') }}</h2>
                <p class="page-subtitle">{{ __('cms.orders.subtitle') ?? 'Manage and track customer orders' }}</p>
            </div>
        </div>
    </div>

    {{-- Orders Table Card --}}
    <div class="card">
        <div class="card-body">
            {{-- Status Filter Tabs --}}
            <ul class="nav status-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-status="all" type="button" role="tab">
                        {{ __('cms.orders.all_orders') ?? 'All Orders' }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-status="pending" type="button" role="tab">
                        {{ __('cms.orders.pending') ?? 'Pending' }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="processing-tab" data-status="processing" type="button" role="tab">
                        {{ __('cms.orders.processing') ?? 'Processing' }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-status="completed" type="button" role="tab">
                        {{ __('cms.orders.completed') ?? 'Completed' }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cancelled-tab" data-status="cancelled" type="button" role="tab">
                        {{ __('cms.orders.cancelled') ?? 'Cancelled' }}
                    </button>
                </li>
            </ul>

            {{-- DataTable --}}
            <div class="table-responsive">
                <table id="orders-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.orders.id') }}</th>
                            <th>{{ __('cms.orders.customer') }}</th>
                            <th style="width: 150px;">{{ __('cms.orders.order_date') }}</th>
                            <th class="text-center" style="width: 120px;">{{ __('cms.orders.status') }}</th>
                            <th style="width: 120px;">{{ __('cms.orders.total_price') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.orders.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.orders.delete_confirm_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ __('cms.orders.delete_confirm_message') }}
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('cms.orders.delete_cancel') }}
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteOrder">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.orders.delete_button') }}
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

{{-- Session-based Toastr --}}
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('cms.orders.success') }}", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif
@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

<script>
$(document).ready(function () {
    let currentStatus = 'all';

    const table = $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.orders.data') }}",
            type: 'POST',
            data: function (d) {
                d._token = "{{ csrf_token() }}";
                d.status = currentStatus;
            }
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'customer',
                name: 'customer',
                orderable: false,
                searchable: true,
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<div class="customer-info">
                                    <span class="customer-name">${data}</span>
                                    ${row.customer_email ? `<span class="customer-email">${row.customer_email}</span>` : ''}
                                </div>`;
                    }
                    return data;
                }
            },
            {
                data: 'order_date',
                name: 'order_date',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<span class="order-date">${data}</span>`;
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data, type, row) {
                    const statusClass = data.toLowerCase();
                    return `<span class="status-badge ${statusClass}">${data}</span>`;
                }
            },
            {
                data: 'total_price',
                name: 'total_price',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<span class="total-price">${data}</span>`;
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
                                <a href="/admin/orders/${row.id}" class="action-btn view-btn" title="View Details">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deleteOrder(${row.id})" title="Delete">
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

    // Handle tab clicks
    $('.status-tabs button').on('click', function() {
        $('.status-tabs button').removeClass('active');
        $(this).addClass('active');
        currentStatus = $(this).data('status');
        table.ajax.reload();
    });

    let orderToDeleteId = null;

    window.deleteOrder = function(id) {
        orderToDeleteId = id;
        $('#deleteOrderModal').modal('show');
    }

    $('#confirmDeleteOrder').on('click', function() {
        if(orderToDeleteId === null) return;

        $.ajax({
            url: '{{ route("admin.orders.destroy", ":id") }}'.replace(':id', orderToDeleteId),
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if(res.success) {
                    table.ajax.reload(null, false);
                    toastr.success(res.message, "{{ __('cms.orders.success') }}", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteOrderModal').modal('hide');
                    orderToDeleteId = null;
                } else {
                    toastr.error(res.message || 'Failed to delete order', "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                }
            },
            error: function() {
                toastr.error('An error occurred while deleting the order', "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                $('#deleteOrderModal').modal('hide');
            }
        });
    });
});
</script>
@endsection
