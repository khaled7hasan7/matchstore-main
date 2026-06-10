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
        Schema::create('shipping_regions', function (Blueprint $table) {
            $table->id();
            $table->enum('country', ['jordan', 'palestine']);
            $table->string('name'); // City/Governorate name in English
            $table->string('name_ar'); // Arabic translation
            $table->string('code')->unique(); // Unique code (e.g., 'JO_AMMAN', 'PS_RAMALLAH')
            $table->string('region_type')->default('city'); // 'governorate', 'city'
            $table->decimal('base_cost', 8, 2)->default(0); // Base shipping cost
            $table->decimal('per_kg_cost', 8, 2)->nullable(); // Cost per kg (optional)
            $table->integer('delivery_days')->default(3); // Estimated delivery time
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for faster queries
            $table->index('country');
            $table->index('code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_regions');
    }
};
