@extends('admin.layouts.admin')

@section('css')
    <style>
        .promo-card-image {
            width: 120px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.375rem;
        }

        .size-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .size-large {
            background: #e7f3ff;
            color: #0066cc;
        }

        .size-small {
            background: #fff3cd;
            color: #856404;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
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

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }

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
    </style>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">{{ __('cms.promo_cards.all_promo_cards') }}</h2>
                <p class="page-subtitle">{{ __('cms.promo_cards.manage_subtitle') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.promo-cards.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('cms.promo_cards.add_promo_card') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Promo Cards Table Card --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('cms.promo_cards.id') }}</th>
                            <th>{{ __('cms.promo_cards.title') }}</th>
                            <th>{{ __('cms.promo_cards.image') }}</th>
                            <th>{{ __('cms.promo_cards.size') }}</th>
                            <th style="width: 100px;">{{ __('cms.promo_cards.order') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.promo_cards.status') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('cms.promo_cards.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promoCards as $card)
                            <tr>
                                <td>{{ $card->id }}</td>
                                <td>
                                    <strong>{{ $card->translations->first()->title ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    @php
                                        $imageUrl = $card->translations->first()->image_url ?? null;
                                    @endphp
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="Promo Card" class="promo-card-image">
                                    @else
                                        <span class="text-muted">{{ __('cms.promo_cards.no_image') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="size-badge size-{{ $card->size }}">{{ $card->size }}</span>
                                </td>
                                <td>{{ $card->order }}</td>
                                <td class="text-center">
                                    <label class="status-switch">
                                        <input type="checkbox" class="toggle-status" data-id="{{ $card->id }}" {{ $card->status ? 'checked' : '' }}>
                                        <span class="status-slider"></span>
                                    </label>
                                </td>
                                <td class="text-center">
                                    <div class="action-btns">
                                        <a href="{{ route('admin.promo-cards.edit', $card->id) }}" class="action-btn edit-btn" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <span class="action-btn delete-btn" onclick="deletePromoCard({{ $card->id }})" title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-muted">{{ __('cms.promo_cards.no_promo_cards') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deletePromoCardModal" tabindex="-1" aria-labelledby="deletePromoCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deletePromoCardModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    {{ __('cms.promo_cards.confirm_title') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{ __('cms.promo_cards.confirm_delete') }}</div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cms.promo_cards.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePromoCard">
                    <i class="bi bi-trash me-2"></i>{{ __('cms.promo_cards.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.promo_cards.success') }}", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $(document).on('change', '.toggle-status', function() {
            var cardId = $(this).data('id');
            var isActive = $(this).prop('checked') ? 1 : 0;
            var toggleElement = $(this);

            $.ajax({
                url: '{{ route('admin.promo-cards.updateStatus') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: cardId,
                    status: isActive
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, "{{ __('cms.promo_cards.updated') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                    } else {
                        toastr.error(response.message, "{{ __('cms.promo_cards.failed') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        toggleElement.prop('checked', !isActive);
                    }
                },
                error: function() {
                    toastr.error('{{ __('cms.promo_cards.error_updating') }}', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    toggleElement.prop('checked', !isActive);
                }
            });
        });
    });

    let promoCardToDeleteId = null;

    function deletePromoCard(id) {
        promoCardToDeleteId = id;
        $('#deletePromoCardModal').modal('show');
    }

    $('#confirmDeletePromoCard').on('click', function() {
        if (promoCardToDeleteId !== null) {
            $.ajax({
                url: '{{ route('admin.promo-cards.destroy', ':id') }}'.replace(':id', promoCardToDeleteId),
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, "{{ __('cms.promo_cards.success') }}", {
                            closeButton: true,
                            progressBar: true,
                            positionClass: "toast-top-right",
                            timeOut: 5000
                        });
                        $('#deletePromoCardModal').modal('hide');
                        location.reload();
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
                    toastr.error('{{ __('cms.promo_cards.error_deleting') }}', "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 5000
                    });
                    $('#deletePromoCardModal').modal('hide');
                }
            });
        }
    });
</script>
@endsection
