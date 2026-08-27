<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'orders';

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'vendor_id',
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'suite',
        'country',
        'region_id',
        'city',
        'zipcode',
        'use_as_billing',
        'billing_address',
        'billing_suite',
        'billing_city',
        'billing_zipcode',
        'payment_method',
        'payment_status',
        'transaction_id',
        'guest_email',
        'total',
        'subtotal',
        'shipping_cost',
        'discount',
        'coupon_code',
        'status',
    ];

    // Define the relationship with the Product model (assuming you have a Product model)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function region()
    {
        return $this->belongsTo(ShippingRegion::class, 'region_id');
    }
}
