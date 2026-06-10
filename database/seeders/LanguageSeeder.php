<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, delete all languages except English and Arabic
        Language::whereNotIn('code', ['en', 'ar'])->delete();

        // Then add/update only English and Arabic
        $languages = [
            ['code' => 'en', 'name' => 'English', 'translated_text' => 'English', 'active' => true],
            ['code' => 'ar', 'name' => 'Arabic', 'translated_text' => 'العربية', 'active' => true],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], [
                'name' => $lang['name'],
                'translated_text' => $lang['translated_text'],
                'active' => $lang['active'],
            ]);
        }
    }
}
