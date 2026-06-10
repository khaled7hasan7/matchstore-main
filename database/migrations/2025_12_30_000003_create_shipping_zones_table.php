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
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Jordan", "Palestine", "Other Countries"
            $table->json('countries'); // Array of country codes (e.g., ['JO'], ['PS'], or ['*'] for all others)
            $table->decimal('base_cost', 8, 2); // Flat rate shipping cost
            $table->decimal('per_kg_cost', 8, 2)->nullable(); // Weight-based additional cost
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};
