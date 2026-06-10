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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('tagline')->nullable()->change();
            $table->string('meta_title')->nullable()->change();
            $table->string('meta_description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('tagline')->nullable(false)->change();
            $table->string('meta_title')->nullable(false)->change();
            $table->string('meta_description')->nullable(false)->change();
        });
    }
};
