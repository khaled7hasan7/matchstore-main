<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * The gateways themselves. Their credentials are seeded separately by
     * PaymentGatewayConfigSeeder, so re-running this never duplicates either.
     */
    public function run(): void
    {
        $gateways = [
            ['code' => 'cod', 'name' => 'Cash on Delivery', 'description' => 'Pay with cash when your order is delivered', 'is_active' => true],
            ['code' => 'paypal', 'name' => 'PayPal', 'description' => 'PayPal payment gateway', 'is_active' => false],
            ['code' => 'stripe', 'name' => 'Stripe', 'description' => 'Stripe payment gateway', 'is_active' => false],
        ];

        foreach ($gateways as $gateway) {
            $exists = DB::table('payment_gateways')->where('code', $gateway['code'])->exists();

            if ($exists) {
                // Keep whatever the store owner has switched on since install.
                DB::table('payment_gateways')
                    ->where('code', $gateway['code'])
                    ->update([
                        'name' => $gateway['name'],
                        'description' => $gateway['description'],
                        'updated_at' => now(),
                    ]);

                continue;
            }

            DB::table('payment_gateways')->insert($gateway + [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
