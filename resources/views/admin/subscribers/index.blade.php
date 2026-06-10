@extends('admin.layouts.admin')

@section('title', __('cms.newsletter.title'))

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ __('cms.newsletter.title') }}</h1>
            <p class="text-muted mb-0">{{ __('cms.newsletter.manage_subscribers') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.subscribers.compose') }}" class="btn btn-primary me-2">
                <i class="fas fa-paper-plane me-2"></i>{{ __('cms.newsletter.send_newsletter') }}
            </a>
            <a href="{{ route('admin.subscribers.export') }}" class="btn btn-success">
                <i class="fas fa-download me-2"></i>{{ __('cms.newsletter.export_csv') }}
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 text-primary rounded">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('cms.newsletter.stats.total_subscribers') }}</h6>
                            <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-lg bg-success bg-opacity-10 text-success rounded">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('cms.newsletter.stats.active') }}</h6>
                            <h3 class="mb-0">{{ number_format($stats['active']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-lg bg-danger bg-opacity-10 text-danger rounded">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">{{ __('cms.newsletter.stats.unsubscribed') }}</h6>
                            <h3 class="mb-0">{{ number_format($stats['unsubscribed']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.subscribers.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">{{ __('cms.newsletter.search_email') }}</label>
                    <input type="text" name="search" class="form-control" placeholder="{{ __('cms.newsletter.search_placeholder') }}" value="{{ $search }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('cms.newsletter.status') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('cms.newsletter.all_statuses') }}</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>{{ __('cms.newsletter.status_active') }}</option>
                        <option value="unsubscribed" {{ $status == 'unsubscribed' ? 'selected' : '' }}>{{ __('cms.newsletter.status_unsubscribed') }}</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>{{ __('cms.newsletter.filter') }}
                    </button>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>{{ __('cms.newsletter.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ __('cms.newsletter.table.id') }}</th>
                            <th>{{ __('cms.newsletter.table.email') }}</th>
                            <th>{{ __('cms.newsletter.table.status') }}</th>
                            <th>{{ __('cms.newsletter.table.subscribed_date') }}</th>
                            <th width="150">{{ __('cms.newsletter.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $subscriber)
                            <tr>
                                <td><span class="text-muted">#{{ $subscriber->id }}</span></td>
                                <td>
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    {{ $subscriber->email }}
                                </td>
                                <td>
                                    @if($subscriber->status === 'active')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>{{ __('cms.newsletter.status_active') }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>{{ __('cms.newsletter.status_unsubscribed') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <i class="far fa-clock text-muted me-2"></i>
                                    {{ $subscriber->created_at->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.subscribers.update-status', $subscriber->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $subscriber->status === 'active' ? 'unsubscribed' : 'active' }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary"
                                                    title="{{ $subscriber->status === 'active' ? __('cms.newsletter.unsubscribe') : __('cms.newsletter.reactivate') }}">
                                                <i class="fas fa-{{ $subscriber->status === 'active' ? 'ban' : 'redo' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('{{ __('cms.newsletter.delete_confirm') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('cms.newsletter.delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>{{ __('cms.newsletter.no_subscribers') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($subscribers->hasPages())
                <div class="mt-4">
                    {{ $subscribers->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<style>
    .avatar {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endsection
