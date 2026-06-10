<?php

namespace App\Http\Controllers\Store\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $orders = Order::with(['details.product.translation', 'details.variant'])
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('themes.xylo.customer.orders', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $customer = Auth::guard('customer')->user();

        $order = Order::with(['details.product.translation', 'details.variant'])
            ->where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('themes.xylo.customer.order-detail', compact('order'));
    }
}
