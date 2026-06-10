@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .amount-badge {
            background: #e7f3ff;
            color: #0066cc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .transaction-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
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
                <h2 class="page-title">{{ __('cms.payments.title') }}</h2>
                <p class="page-subtitle">{{ __('cms.payments.subtitle') ?? 'Manage payment transactions' }}</p>
            </div>
        </div>
    </div>

    {{-- Payments Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="payments-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.payments.id') }}</th>
                            <th>{{ __('cms.payments.order') }}</th>
                            <th>{{ __('cms.payments.user') }}</th>
                            <th>{{ __('cms.payments.gateway') }}</th>
                            <th style="width: 120px;">{{ __('cms.payments.amount') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.payments.status') }}</th>
                            <th>{{ __('cms.payments.transaction') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.payments.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deletePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.payments.delete_confirm') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ __('cms.payments.delete_message') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.payments.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePayment">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.payments.delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.payments.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#payments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payments.getData') }}",
        language: @json($datatableLang),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'order', name: 'order_id' },
            { data: 'user', name: 'user_id' },
            { data: 'gateway', name: 'gateway_id' },
            {
                data: 'amount',
                name: 'amount',
                render: function(data) {
                    return '<span class="amount-badge">$' + data + '</span>';
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data) {
                    if (data === 'completed' || data === 'paid') {
                        return '<span class="status-badge active">Paid</span>';
                    } else if (data === 'failed') {
                        return '<span class="status-badge inactive">Failed</span>';
                    } else {
                        return '<span class="status-badge" style="background: #fff3cd; color: #856404;">Pending</span>';
                    }
                }
            },
            {
                data: 'transaction_id',
                name: 'transaction_id',
                render: function(data) {
                    return '<span class="transaction-id">' + (data || 'N/A') + '</span>';
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <a href="/admin/payments/${row.id}" class="action-btn view-btn" title="View" style="background: #d1ecf1; border: 1px solid #0dcaf0;">
                                    <i class="bi bi-eye-fill" style="color: #055160;"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deletePayment(${row.id})" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </span>
                            </div>`;
                }
            }
        ],
        pageLength: 10,
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });
});

let paymentToDeleteId = null;

function deletePayment(id) {
    paymentToDeleteId = id;
    $('#deletePaymentModal').modal('show');

    $('#confirmDeletePayment').off('click').on('click', function() {
        if (paymentToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payments.destroy', ':id') }}'.replace(':id', paymentToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#payments-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.payments.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deletePaymentModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error('{{ __("cms.payments.error_delete") ?? "Error deleting payment!" }}', "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deletePaymentModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection