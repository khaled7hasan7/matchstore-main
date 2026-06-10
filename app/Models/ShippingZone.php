<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'countries',
        'base_cost',
        'per_kg_cost',
        'is_active',
    ];

    protected $casts = [
        'countries' => 'array',
        'base_cost' => 'decimal:2',
        'per_kg_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Calculate shipping cost for a given weight and country code.
     *
     * @param float $weight Weight in kilograms
     * @param string $countryCode ISO country code (e.g., 'JO', 'PS')
     * @return float|null Shipping cost or null if country not in this zone
     */
    public function calculateShippingCost($weight, $countryCode)
    {
        // Check if this zone applies to all countries (wildcard *)
        if (in_array('*', $this->countries)) {
            return $this->base_cost + ($this->per_kg_cost * $weight);
        }

        // Check if the specific country code is in this zone
        if (in_array($countryCode, $this->countries)) {
            return $this->base_cost + ($this->per_kg_cost * $weight);
        }

        return null;
    }

    /**
     * Scope to get only active shipping zones.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get shipping cost for a country across all active zones.
     *
     * @param string $countryCode ISO country code
     * @param float $weight Weight in kilograms
     * @return float|null Shipping cost or null if no zone found
     */
    public static function getCostForCountry($countryCode, $weight = 0)
    {
        $zones = self::active()->get();

        foreach ($zones as $zone) {
            $cost = $zone->calculateShippingCost($weight, $countryCode);
            if ($cost !== null) {
                return $cost;
            }
        }

        return null;
    }
}
