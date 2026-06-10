<?php

namespace App\Services\Store;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function applyCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) {
            return ['success' => false, 'message' => __('store.cart.invalid_coupon')];
        }

        if ($coupon->isExpired()) {
            return ['success' => false, 'message' => __('store.cart.coupon_expired')];
        }

        Session::put('cart_coupon', $coupon);

        return ['success' => true, 'message' => __('store.cart.coupon_applied'), 'discount' => $coupon->discount, 'type' => $coupon->type];
    }

    public function getCartTotalWithDiscount($total)
    {
        $coupon = Session::get('cart_coupon');

        if (! $coupon) {
            return $total;
        }

        if ($coupon->type === 'percentage') {
            return $total - ($total * ($coupon->discount / 100));
        } else {
            return max(0, $total - $coupon->discount);
        }
    }

    public function removeCoupon()
    {
        Session::forget('cart_coupon');
    }
}
