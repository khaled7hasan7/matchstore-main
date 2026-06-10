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
        Schema::create('promo_cards', function (Blueprint $table) {
            $table->id();
            $table->string('size')->default('large'); // large, small
            $table->integer('order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('promo_card_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_card_id')->constrained('promo_cards')->onDelete('cascade');
            $table->string('language_code', 10);
            $table->string('badge_text')->nullable();
            $table->string('title');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->unique(['promo_card_id', 'language_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_card_translations');
        Schema::dropIfExists('promo_cards');
    }
};
