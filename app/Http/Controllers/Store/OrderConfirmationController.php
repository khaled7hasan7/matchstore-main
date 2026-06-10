<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderConfirmationController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with(['details.product.translations', 'customer'])
            ->findOrFail($orderId);

        // Verify the order belongs to the current customer
        if ($order->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('themes.xylo.order-confirmation', compact('order'));
    }
}
