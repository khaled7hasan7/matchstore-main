<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * password_resets is the customers' password-broker table (config/auth.php)
     * and must stay, but it has no primary key, which PostgreSQL/Supabase
     * flags and which blocks logical replication. The broker keeps one row
     * per email, so email is a natural key.
     */
    public function up(): void
    {
        // SQLite cannot add a primary key to an existing table; it is only
        // used for the in-memory test database, so skip it there.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // Clear the table so the constraint can never collide with stale
        // duplicate rows — reset tokens are disposable and get re-requested.
        DB::table('password_resets')->delete();

        Schema::table('password_resets', function (Blueprint $table) {
            $table->primary('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropPrimary(['email']);
        });
    }
};
