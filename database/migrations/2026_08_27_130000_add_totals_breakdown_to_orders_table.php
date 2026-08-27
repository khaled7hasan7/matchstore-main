<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->nullable()->after('total');
            $table->decimal('shipping_cost', 8, 2)->default(0)->after('subtotal');
            $table->decimal('discount', 10, 2)->default(0)->after('shipping_cost');
            $table->string('coupon_code', 50)->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'shipping_cost', 'discount', 'coupon_code']);
        });
    }
};
