@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .rating-stars {
            color: #ffc107;
            font-size: 1rem;
        }

        .rating-number {
            font-weight: 600;
            color: #212529;
            margin-left: 0.25rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.product_reviews.title_manage') }}</h2>
                <p class="page-subtitle">{{ __('cms.product_reviews.subtitle') ?? 'Manage product reviews and ratings' }}</p>
            </div>
        </div>
    </div>

    {{-- Reviews Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="reviews-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.product_reviews.review_id') }}</th>
                            <th>{{ __('cms.product_reviews.customer_name') }}</th>
                            <th>{{ __('cms.product_reviews.product_name') }}</th>
                            <th class="text-center" style="width: 120px;">{{ __('cms.product_reviews.rating') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.product_reviews.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.product_reviews.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Review Modal --}}
<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.product_reviews.confirm_delete') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">{{ __('cms.product_reviews.delete_message') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('cms.product_reviews.cancel') }}
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteReview">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.product_reviews.delete') }}
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
    toastr.success("{{ session('success') }}", "{{ __('cms.product_reviews.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.reviews.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'product_name', name: 'product_name' },
            {
                data: 'rating',
                name: 'rating',
                className: 'text-center',
                render: function(data) {
                    let stars = '';
                    for(let i = 1; i <= 5; i++) {
                        if(i <= data) {
                            stars += '<i class="bi bi-star-fill rating-stars"></i>';
                        } else {
                            stars += '<i class="bi bi-star rating-stars" style="color: #ddd;"></i>';
                        }
                    }
                    return `<div>${stars}<span class="rating-number">${data}/5</span></div>`;
                }
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center',
                render: function(data) {
                    return data === 'active'
                        ? '<span class="status-badge active">Approved</span>'
                        : '<span class="status-badge inactive">Pending</span>';
                }
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `<div class="action-btns">
                                <a href="/admin/reviews/${row.id}" class="action-btn view-btn" title="View">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <span class="action-btn delete-btn" onclick="deleteReview(${row.id})" title="Delete">
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

let reviewToDeleteId = null;

function deleteReview(id) {
    reviewToDeleteId = id;
    $('#deleteReviewModal').modal('show');

    $('#confirmDeleteReview').off('click').on('click', function() {
        if (reviewToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.reviews.destroy', ':id') }}'.replace(':id', reviewToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        $('#reviews-table').DataTable().ajax.reload();
                        toastr.success(response.message, "{{ __('cms.product_reviews.deleted') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deleteReviewModal').modal('hide');
                    }
                },
                error: function() {
                    toastr.error("{{ __('cms.product_reviews.error_delete') }}", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deleteReviewModal').modal('hide');
                }
            });
        }
    });
}
</script>
@endsection
