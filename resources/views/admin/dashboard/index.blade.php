@extends('admin.layouts.admin')

@section('css')
<style>
    .dashboard-wrapper {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .dashboard-header {
        background: white;
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: 1px solid #e0e0e0;
    }

    .dashboard-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d2d2d;
        margin: 0;
    }

    .dashboard-header p {
        color: #6c757d;
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        height: 100%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: white;
    }

    .stat-icon.primary {
        background: #595959;
    }

    .stat-icon.success {
        background: #28a745;
    }

    .stat-icon.warning {
        background: #ffc107;
    }

    .stat-icon.info {
        background: #17a2b8;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 0.5rem;
    }

    .stat-change {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .recent-section {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-top: 2rem;
        border: 1px solid #e0e0e0;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: #595959;
    }

    .recent-orders-table {
        margin-bottom: 0;
    }

    .recent-orders-table thead {
        background: #595959;
        color: white;
    }

    .recent-orders-table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .recent-orders-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 0.9rem;
    }

    .recent-orders-table tbody tr:last-child td {
        border-bottom: none;
    }

    .recent-orders-table tbody tr:hover {
        background: #f8f9fa;
    }

    .quick-actions {
        background: white;
        border-radius: 0.5rem;
        padding: 1.75rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-top: 2rem;
        border: 1px solid #e0e0e0;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #2d2d2d;
        margin-bottom: 0.75rem;
    }

    .quick-action-btn:hover {
        background: #595959;
        color: white;
        border-color: #595959;
        transform: translateX(3px);
    }

    .quick-action-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        background: white;
        color: #595959;
        border: 1px solid #e0e0e0;
    }

    .quick-action-btn:hover .quick-action-icon {
        background: rgba(255,255,255,0.15);
        color: white;
        border-color: transparent;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .stat-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 1rem 0;
        }

        .stat-card {
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .dashboard-header h2 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h2><i class="fas fa-chart-line me-2"></i>{{ __('cms.dashboard.title') }}</h2>
            <p>{{ __('cms.dashboard.subtitle') }}</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <!-- Total Sales Card -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-label">{{ __('cms.dashboard.total_sales') }}</div>
                    <div class="stat-value">${{ number_format($data['totalSales'], 2) }}</div>
                    <div class="stat-change">
                        <strong>{{ __('cms.dashboard.today') }}:</strong> ${{ number_format($data['todaySales'], 2) }}
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-label">{{ __('cms.dashboard.total_orders') }}</div>
                    <div class="stat-value">{{ $data['totalOrders'] }}</div>
                    <div class="stat-change">
                        <strong>{{ __('cms.dashboard.completed') }}:</strong> {{ $data['completedOrders'] }}
                    </div>
                </div>
            </div>

            <!-- Total Vendors Card -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="stat-label">{{ __('cms.dashboard.active_vendors') }}</div>
                    <div class="stat-value">{{ $data['totalVendors'] }}</div>
                    <div class="stat-change">
                        {{ __('cms.dashboard.all_active_accounts') }}
                    </div>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-label">{{ __('cms.dashboard.total_customers') }}</div>
                    <div class="stat-value">{{ $data['totalCustomers'] }}</div>
                    <div class="stat-change">
                        {{ __('cms.dashboard.active_customer_base') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Orders Section -->
            <div class="col-lg-8">
                <div class="recent-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-clock"></i>
                            {{ __('cms.dashboard.recent_orders') }}
                        </h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-dark">
                            {{ __('cms.dashboard.view_all') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table recent-orders-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('cms.dashboard.order_id') }}</th>
                                        <th>{{ __('cms.dashboard.customer') }}</th>
                                        <th>{{ __('cms.dashboard.date') }}</th>
                                        <th>{{ __('cms.dashboard.total') }}</th>
                                        <th>{{ __('cms.dashboard.status') }}</th>
                                        <th>{{ __('cms.dashboard.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>
                                                @if($order->customer)
                                                    {{ $order->customer->name }}
                                                @else
                                                    {{ $order->first_name }} {{ $order->last_name }}
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                    ];
                                                    $color = $statusColors[$order->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p class="mb-0">{{ __('cms.dashboard.no_recent_orders') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="col-lg-4">
                <div class="quick-actions">
                    <h5 class="section-title">
                        <i class="fas fa-bolt"></i>
                        {{ __('cms.dashboard.quick_actions') }}
                    </h5>

                    <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <strong>{{ __('cms.dashboard.add_new_product') }}</strong>
                            <div style="font-size: 0.8rem; color: #6c757d;">{{ __('cms.dashboard.add_new_product_desc') }}</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <strong>{{ __('cms.dashboard.manage_orders') }}</strong>
                            <div style="font-size: 0.8rem; color: #6c757d;">{{ __('cms.dashboard.manage_orders_desc') }}</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.customers.index') }}" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div>
                            <strong>{{ __('cms.dashboard.view_customers') }}</strong>
                            <div style="font-size: 0.8rem; color: #6c757d;">{{ __('cms.dashboard.view_customers_desc') }}</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.coupons.create') }}" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <strong>{{ __('cms.dashboard.create_coupon') }}</strong>
                            <div style="font-size: 0.8rem; color: #6c757d;">{{ __('cms.dashboard.create_coupon_desc') }}</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.site-settings.index') }}" class="quick-action-btn">
                        <div class="quick-action-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div>
                            <strong>{{ __('cms.dashboard.site_settings') }}</strong>
                            <div style="font-size: 0.8rem; color: #6c757d;">{{ __('cms.dashboard.site_settings_desc') }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
