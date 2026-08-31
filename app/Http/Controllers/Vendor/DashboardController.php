<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::guard('vendor')->id();

        $data = [
            'totalSales' => Order::where('vendor_id', $vendorId)
                ->where('status', 'completed')
                ->sum('total'),

            'todaySales' => Order::where('vendor_id', $vendorId)
                ->where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('total'),

            'totalOrders' => Order::where('vendor_id', $vendorId)->count(),

            'completedOrders' => Order::where('vendor_id', $vendorId)
                ->where('status', 'completed')
                ->count(),

            'totalProducts' => Product::where('vendor_id', $vendorId)->count(),
        ];

        return view('vendor.dashboard.index', compact('data'));
    }
}
