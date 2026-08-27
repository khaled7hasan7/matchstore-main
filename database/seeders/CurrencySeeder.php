<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Idempotent: currency rows may already exist from data migrations
        foreach ([
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => 1.0000,
            ],
            [
                'name' => 'Jordanian Dinar',
                'code' => 'JOD',
                'symbol' => 'د.ا',
                'exchange_rate' => 0.7090,
            ],
        ] as $currency) {
            DB::table('currencies')->updateOrInsert(
                ['code' => $currency['code']],
                $currency + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
