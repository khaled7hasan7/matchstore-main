<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Jordan',
                'countries' => ['JO'],
                'base_cost' => 5.00,
                'per_kg_cost' => 2.00,
                'is_active' => true,
            ],
            [
                'name' => 'Palestine',
                'countries' => ['PS'],
                'base_cost' => 7.00,
                'per_kg_cost' => 2.50,
                'is_active' => true,
            ],
            [
                'name' => 'Other Countries',
                'countries' => ['*'], // Wildcard for all other countries
                'base_cost' => 15.00,
                'per_kg_cost' => 5.00,
                'is_active' => true,
            ],
        ];

        foreach ($zones as $zone) {
            ShippingZone::create($zone);
        }
    }
}
