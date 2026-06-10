@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .gateway-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #6c757d;
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.payment_gateways.title') }}</h2>
                <p class="page-subtitle">{{ __('cms.payment_gateways.subtitle') ?? 'Manage payment gateway configurations' }}</p>
            </div>
        </div>
    </div>

    {{-- Payment Gateways Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="gateways-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.payment_gateways.id') }}</th>
                            <th>{{ __('cms.payment_gateways.name') }}</th>
                            <th style="width: 150px;">{{ __('cms.payment_gateways.code') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.payment_gateways.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.payment_gateways.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteGatewayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.payment_gateways.delete_confirm') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ __('cms.payment_gateways.delete_message') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('cms.payment_gateways.cancel') }}
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteGateway">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.payment_gateways.delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.payment_gateways.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#gateways-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payment-gateways.getData') }}",
        language: @json($datatableLang),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            {
                data: 'code',
                name: 'code',
                render: function(data) {
                    return '<span class="gateway-code">' + data + '</span>';
                }
            },
            {
                data: 'status',
                name: 'is_active',
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return data
                        ? '<span class="status-badge active">{{ __('cms.payment_gateways.active') }}</span>'
                        : '<span class="status-badge inactive">{{ __('cms.payment_gateways.inactive') }}</span>';
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <a href="/admin/payment-gateways/${row.id}/edit" class="action-btn edit-btn" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deleteGateway(${row.id})" title="Delete">
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

let gatewayToDeleteId = null;

function deleteGateway(id) {
    gatewayToDeleteId = id;
    $('#deleteGatewayModal').modal('show');

    $('#confirmDeleteGateway').off('click').on('click', function() {
        if (gatewayToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.payment-gateways.destroy', ':id') }}'.replace(':id', gatewayToDeleteId),
                method: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.success) {
                        $('#gateways-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.payment_gateways.deleted') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteGatewayModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error("{{ __('cms.payment_gateways.error_delete') }}", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteGatewayModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
