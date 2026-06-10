<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingRegion;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Get shipping regions by country
     */
    public function getRegionsByCountry($country)
    {
        try {
            $regions = ShippingRegion::getByCountry($country);

            return response()->json([
                'success' => true,
                'regions' => $regions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading regions',
            ], 500);
        }
    }

    /**
     * Calculate shipping cost
     */
    public function calculateShipping(Request $request)
    {
        try {
            $request->validate([
                'region_id' => 'required|exists:shipping_regions,id',
                'weight' => 'nullable|numeric|min:0',
            ]);

            $region = ShippingRegion::findOrFail($request->region_id);
            $weight = $request->weight ?? 1;

            $shippingCost = $region->calculateShipping($weight);

            return response()->json([
                'success' => true,
                'shipping_cost' => $shippingCost,
                'delivery_days' => $region->delivery_days,
                'region' => [
                    'id' => $region->id,
                    'name' => $region->name,
                    'name_ar' => $region->name_ar,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating shipping cost',
            ], 500);
        }
    }

    /**
     * Get all active regions (optional - for admin or display purposes)
     */
    public function getAllRegions()
    {
        try {
            $regions = ShippingRegion::where('is_active', true)
                ->orderBy('country')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'regions' => $regions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading regions',
            ], 500);
        }
    }
}
