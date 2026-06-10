<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove EUR and GBP currencies
        DB::table('currencies')->whereIn('code', ['EUR', 'GBP'])->delete();

        // Add Jordanian Dinar if it doesn't exist
        $jodExists = DB::table('currencies')->where('code', 'JOD')->exists();

        if (!$jodExists) {
            DB::table('currencies')->insert([
                'name' => 'Jordanian Dinar',
                'code' => 'JOD',
                'symbol' => 'د.ا',
                'exchange_rate' => 0.7090,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Jordanian Dinar
        DB::table('currencies')->where('code', 'JOD')->delete();

        // Re-add EUR and GBP
        DB::table('currencies')->insert([
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => 0.9200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
                'exchange_rate' => 0.7900,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
