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
            // Customer information
            $table->string('first_name')->after('customer_id');
            $table->string('last_name')->after('first_name');
            $table->string('email')->after('last_name');
            $table->string('phone', 20)->after('email');

            // Shipping address
            $table->string('address', 500)->after('phone');
            $table->string('suite', 100)->nullable()->after('address');
            $table->string('country', 100)->after('suite');
            $table->unsignedBigInteger('region_id')->nullable()->after('country');
            $table->string('city', 100)->after('region_id');
            $table->string('zipcode', 20)->after('city');

            // Billing address (optional - can be same as shipping)
            $table->boolean('use_as_billing')->default(true)->after('zipcode');
            $table->string('billing_address', 500)->nullable()->after('use_as_billing');
            $table->string('billing_suite', 100)->nullable()->after('billing_address');
            $table->string('billing_city', 100)->nullable()->after('billing_suite');
            $table->string('billing_zipcode', 20)->nullable()->after('billing_city');

            // Payment information
            $table->string('payment_method', 50)->after('billing_zipcode');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_status');

            // Rename total_amount to total for consistency
            $table->renameColumn('total_amount', 'total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop all added columns
            $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'suite',
                'country',
                'region_id',
                'city',
                'zipcode',
                'use_as_billing',
                'billing_address',
                'billing_suite',
                'billing_city',
                'billing_zipcode',
                'payment_method',
                'payment_status',
                'transaction_id',
            ]);

            // Rename total back to total_amount
            $table->renameColumn('total', 'total_amount');
        });
    }
};
