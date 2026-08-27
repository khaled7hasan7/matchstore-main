<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderConfirmationController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with(['details.product.translations', 'customer', 'region'])
            ->findOrFail($orderId);

        // A customer may only view their own orders; a guest may only view
        // the order they just placed in this session.
        $isOwner = auth('customer')->check()
            && $order->customer_id === auth('customer')->id();

        $isGuestOrder = $order->customer_id === null
            && (int) session('last_order_id') === (int) $order->id;

        if (! $isOwner && ! $isGuestOrder) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('themes.xylo.order-confirmation', compact('order'));
    }
}
