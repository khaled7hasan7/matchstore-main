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
        DB::table('currencies')->insert([
            'name' => 'Israeli New Shekel',
            'code' => 'NIS',
            'symbol' => '₪',
            'exchange_rate' => 3.65, // Exchange rate vs USD (approximate)
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('currencies')->where('code', 'NIS')->delete();
    }
};
