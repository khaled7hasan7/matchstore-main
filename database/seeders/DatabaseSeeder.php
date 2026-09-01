<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Everything a new store needs, in dependency order, and nothing else.
     *
     * Deliberately excluded: OrderSeeder, PaymentSeeder and RefundSeeder,
     * which invent transactions a real store must not start life with, and the
     * generic demo catalogue, which the store seeder replaces anyway.
     *
     * Every seeder called here is safe to run again.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            ShippingRegionSeeder::class,
            PaymentGatewaySeeder::class,
            PaymentGatewayConfigSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            StorePagesSeeder::class,
            SiteSettingsSeeder::class,
            FalakStoreSeeder::class,
        ]);
    }
}
