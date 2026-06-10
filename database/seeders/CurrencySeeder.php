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
        DB::table('currencies')->insert([
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => 1.0000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jordanian Dinar',
                'code' => 'JOD',
                'symbol' => 'د.ا',
                'exchange_rate' => 0.7090,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
