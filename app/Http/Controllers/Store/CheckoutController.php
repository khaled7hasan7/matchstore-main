<?php

namespace App\Http\Controllers\Store;

use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Mail\NewOrderAdminMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\VendorOrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentGateway;
use App\Models\ProductVariant;
use App\Models\ShippingRegion;
use App\Models\SiteSetting;
use App\Services\PaymentGateway\PaymentManager;
use App\Services\Store\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', __('store.checkout.cart_empty'));
        }

        $paymentGateways = PaymentGateway::with('configs')
            ->where('is_active', 1)
            ->get();

        $paypal = $paymentGateways->firstWhere('code', 'paypal');
        $paypalClientId = $paypal
            ? $paypal->getConfigValue('client_id', 'sandbox')
            : null;

        $stripe = $paymentGateways->firstWhere('code', 'stripe');
        $stripePublicKey = $stripe
            ? $stripe->getConfigValue('public_key', 'sandbox')
            : null;

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $coupon = Session::get('cart_coupon');
        $discount = $this->couponDiscount($coupon, $subtotal);

        // Shipping is chosen client-side per region; the authoritative cost
        // is recalculated server-side in process().
        $shipping = null;
        $total = max(0, $subtotal - $discount);

        return view('themes.xylo.checkout', compact(
            'cart', 'subtotal', 'discount', 'coupon', 'shipping', 'total',
            'paymentGateways', 'paypalClientId', 'stripePublicKey'
        ));
    }

    public function process(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'gateway' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'country' => 'required|string',
            'region_id' => 'required|integer|exists:shipping_regions,id',
            'city' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $gatewayCode = $request->input('gateway');

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', __('store.checkout.cart_empty'));
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        // Re-validate the coupon at order time — it may have expired since it
        // was applied to the cart.
        $coupon = Session::get('cart_coupon');
        if ($coupon) {
            $coupon = Coupon::find($coupon->id);

            if (! $coupon || $coupon->isExpired()) {
                Session::forget('cart_coupon');

                return back()->withInput()->with('error', __('store.cart.coupon_expired'));
            }
        }
        $discount = $this->couponDiscount($coupon, $subtotal);

        // Authoritative shipping cost from the selected region — never trust
        // the client-side figure.
        $region = ShippingRegion::where('id', $validated['region_id'])
            ->where('is_active', true)
            ->first();

        if (! $region) {
            return back()->withInput()->with('error', __('store.checkout.region_invalid'));
        }

        $shippingCost = $region->calculateShipping(1);
        $amount = max(0, $subtotal - $discount) + $shippingCost;
        $city = $validated['city'] ?: (app()->getLocale() === 'ar' ? $region->name_ar : $region->name);

        try {
            // Handle Cash on Delivery separately
            if ($gatewayCode === 'cod') {
                try {
                    $order = DB::transaction(function () use ($validated, $request, $cart, $subtotal, $discount, $coupon, $region, $shippingCost, $amount, $city) {
                        $this->reserveStock($cart);

                        $order = Order::create([
                            'customer_id' => Auth::guard('customer')->id(),
                            'guest_email' => Auth::guard('customer')->check() ? null : $validated['email'],
                            'first_name' => $validated['first_name'],
                            'last_name' => $validated['last_name'],
                            'email' => $validated['email'],
                            'phone' => $validated['phone'],
                            'address' => $validated['address'],
                            'suite' => $request->input('suite'),
                            'country' => $validated['country'],
                            'region_id' => $region->id,
                            'city' => $city,
                            'zipcode' => $validated['zipcode'] ?? '',
                            'payment_method' => 'cod',
                            'payment_status' => 'pending',
                            'subtotal' => $subtotal,
                            'shipping_cost' => $shippingCost,
                            'discount' => $discount,
                            'coupon_code' => $coupon->code ?? null,
                            'total' => $amount,
                            'status' => 'pending',
                        ]);

                        foreach ($cart as $item) {
                            OrderDetail::create([
                                'order_id' => $order->id,
                                'product_id' => $item['product_id'],
                                'variant_id' => $item['variant_id'] ?? null,
                                'quantity' => $item['quantity'],
                                'price' => $item['price'],
                                'attributes' => json_encode($item['attributes'] ?? []),
                            ]);
                        }

                        return $order;
                    });
                } catch (InsufficientStockException $e) {
                    return back()->withInput()->with('error', __('store.checkout.out_of_stock', ['name' => $e->itemName]));
                }

                Session::forget(['cart', 'cart_count', 'cart_coupon']);
                // Lets a guest view the confirmation page for this order only
                Session::put('last_order_id', $order->id);

                $this->sendOrderMails($order);

                return redirect()->route('order.confirmation', ['orderId' => $order->id])
                    ->with('success', __('store.checkout.order_success'));
            }

            // Handle other payment gateways (PayPal, Stripe, etc.)
            $paymentService = PaymentManager::make($gatewayCode, 'sandbox');
            $order = $paymentService->createOrder($amount, 'USD');

            return response()->json([
                'success' => true,
                'gateway' => $gatewayCode,
                'order' => $order,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment process failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Queue the order emails: confirmation to the customer, a notification
     * to the store admin, and one per vendor with only their items.
     *
     * Mail must never break a placed order — every dispatch is guarded and
     * failures are only logged.
     */
    protected function sendOrderMails(Order $order): void
    {
        $order->load(['details.product.translations', 'details.product.vendor', 'region']);

        $locale = app()->getLocale();
        $siteSettings = SiteSetting::first();
        $storeName = $siteSettings->site_name ?? config('app.name');
        $symbol = activeCurrency()->symbol ?? '$';

        try {
            Mail::to($order->email)
                ->send((new OrderConfirmationMail($order, $symbol, $storeName))->locale($locale));
        } catch (\Throwable $e) {
            Log::error("Order #{$order->id}: confirmation mail failed: ".$e->getMessage());
        }

        try {
            $adminEmail = $siteSettings->contact_email ?? config('mail.from.address');

            if ($adminEmail) {
                Mail::to($adminEmail)
                    ->send((new NewOrderAdminMail($order, $symbol, $storeName))->locale($locale));
            }
        } catch (\Throwable $e) {
            Log::error("Order #{$order->id}: admin mail failed: ".$e->getMessage());
        }

        foreach ($order->details->groupBy(fn ($detail) => $detail->product?->vendor_id) as $vendorId => $details) {
            if (! $vendorId) {
                continue;
            }

            $vendor = $details->first()->product->vendor;

            if (! $vendor || ! $vendor->email) {
                continue;
            }

            try {
                Mail::to($vendor->email)
                    ->send((new VendorOrderMail($order, $vendor, $details, $symbol, $storeName))->locale($locale));
            } catch (\Throwable $e) {
                Log::error("Order #{$order->id}: vendor mail failed for vendor {$vendorId}: ".$e->getMessage());
            }
        }
    }

    /**
     * Lock the cart's variants, verify availability and decrement stock.
     * Must run inside a database transaction.
     */
    protected function reserveStock(array $cart): void
    {
        foreach ($cart as $item) {
            if (empty($item['variant_id'])) {
                continue;
            }

            $variant = ProductVariant::whereKey($item['variant_id'])
                ->lockForUpdate()
                ->first();

            if (! $variant || $variant->stock < $item['quantity']) {
                throw new InsufficientStockException($item['variant_name'] ?? '#'.$item['product_id']);
            }

            $variant->decrement('stock', $item['quantity']);
        }
    }

    protected function couponDiscount(?Coupon $coupon, float $subtotal): float
    {
        if (! $coupon) {
            return 0.0;
        }

        if ($coupon->type === 'percentage') {
            return round($subtotal * ($coupon->discount / 100), 2);
        }

        return round(min($coupon->discount, $subtotal), 2);
    }

    /**
     * PayPal success callback
     */
    public function paypalSuccess(Request $request, OrderService $orderService)
    {
        $orderId = $request->query('token'); // PayPal returns ?token=ORDER_ID

        try {
            $paypal = PaymentManager::make('paypal', 'sandbox');
            $result = $paypal->captureOrder($orderId);

            if (($result['status'] ?? null) === 'COMPLETED') {

                $order = $orderService->createOrderFromPaypal($result);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment completed & order stored successfully.',
                    'order_id' => $order->id,
                    'details' => $result,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment not completed.',
                'details' => $result,
            ]);
        } catch (\Exception $e) {
            \Log::error('PayPal success error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * PayPal cancel callback
     */
    public function paypalCancel()
    {
        return response()->json([
            'success' => false,
            'message' => 'Payment was cancelled by user.',
        ]);
    }
}
