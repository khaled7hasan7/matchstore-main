<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'name',
        'name_ar',
        'code',
        'region_type',
        'base_cost',
        'per_kg_cost',
        'delivery_days',
        'is_active',
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'per_kg_cost' => 'decimal:2',
        'delivery_days' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get regions by country
     */
    public static function getByCountry($country)
    {
        return self::where('country', $country)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Calculate shipping cost based on weight
     */
    public function calculateShipping($weight = 1)
    {
        $cost = $this->base_cost;

        if ($this->per_kg_cost && $weight > 1) {
            $cost += ($weight - 1) * $this->per_kg_cost;
        }

        return round($cost, 2);
    }
}
