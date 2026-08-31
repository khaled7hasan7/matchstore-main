<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Baseline site settings. Only written when none exist, so re-seeding
     * never overwrites what the store owner has configured.
     */
    public function run(): void
    {
        if (DB::table('site_settings')->exists()) {
            return;
        }

        DB::table('site_settings')->insert([
            'site_name' => 'MatchStore',
            'tagline' => 'متجر إلكتروني',
            'meta_title' => 'MatchStore',
            'meta_description' => 'متجر إلكتروني',
            'meta_keywords' => null,
            'contact_email' => null,
            'contact_phone' => null,
            'address' => null,
            'footer_text' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
