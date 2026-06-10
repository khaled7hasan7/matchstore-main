@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.vendors.title_list') }}</h2>
                <p class="page-subtitle">{{ __('cms.vendors.subtitle') ?? 'Manage vendor accounts' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.vendors.add_new') ?? 'Add Vendor' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Vendors Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="vendors-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.vendors.id') }}</th>
                            <th>{{ __('cms.vendors.name') }}</th>
                            <th>{{ __('cms.vendors.email') }}</th>
                            <th>{{ __('cms.vendors.phone') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.vendors.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.vendors.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteVendorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.vendors.modal_confirm_delete_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{ __('cms.vendors.modal_confirm_delete_body') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.vendors.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteVendor">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.vendors.delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.vendors.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#vendors-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.vendors.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data) {
                    return data === 'active'
                        ? '<span class="status-badge active">{{ __('cms.vendors.active') }}</span>'
                        : '<span class="status-badge inactive">{{ __('cms.vendors.inactive') }}</span>';
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <span class="action-btn delete-btn" onclick="deleteVendor(${row.id})" title="Delete">
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

let vendorToDeleteId = null;

function deleteVendor(id) {
    vendorToDeleteId = id;
    $('#deleteVendorModal').modal('show');

    $('#confirmDeleteVendor').off('click').on('click', function() {
        if (vendorToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.vendors.destroy', ':id') }}'.replace(':id', vendorToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#vendors-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.vendors.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteVendorModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error("{{ __('cms.vendors.error_delete') }}", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteVendorModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection