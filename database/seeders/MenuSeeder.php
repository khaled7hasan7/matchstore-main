<?php

namespace Database\Seeders;

use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::where('active', 1)->get();

        if ($languages->isEmpty()) {
            $this->command->warn('⚠️ No active languages found. Skipping menu item translations.');

            return;
        }

        // Get existing menu or create new one
        $menu = DB::table('menus')->where('title', 'Main Menu')->first();

        if (!$menu) {
            $menuId = DB::table('menus')->insertGetId([
                'title' => 'Main Menu',
                'status' => true,
                'date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $menuId = $menu->id;
        }

        $menuItemsData = [
            ['slug' => 'home', 'order_number' => 1, 'parent_id' => null],
            ['slug' => 'about', 'order_number' => 2, 'parent_id' => null],
            ['slug' => 'services', 'order_number' => 3, 'parent_id' => null],
            ['slug' => 'blog', 'order_number' => 4, 'parent_id' => null],
            ['slug' => 'contact', 'order_number' => 5, 'parent_id' => null],
        ];

        foreach ($menuItemsData as $itemData) {
            DB::table('menu_items')->updateOrInsert(
                ['slug' => $itemData['slug']],
                [
                    'menu_id' => $menuId,
                    'order_number' => $itemData['order_number'],
                    'parent_id' => $itemData['parent_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        $insertedMenuItems = DB::table('menu_items')->where('menu_id', $menuId)->orderBy('order_number')->get();

        $defaultTitles = ['Home', 'About Us', 'Our Services', 'Blog', 'Contact Us'];

        $localizedSamples = [
            'ar' => ['الرئيسية', 'من نحن', 'خدماتنا', 'المدونة', 'اتصل بنا'],
            'fr' => ['Accueil', 'À propos', 'Nos services', 'Blog', 'Contact'],
            'es' => ['Inicio', 'Sobre nosotros', 'Nuestros servicios', 'Blog', 'Contacto'],
        ];

        foreach ($insertedMenuItems as $index => $menuItem) {
            foreach ($languages as $lang) {
                $code = $lang->code;

                $title = $localizedSamples[$code][$index]
                    ?? $defaultTitles[$index]
                    ?? ucfirst($menuItem->slug);

                DB::table('menu_item_translations')->updateOrInsert(
                    [
                        'menu_item_id' => $menuItem->id,
                        'language_code' => $code,
                    ],
                    [
                        'title' => $title,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }

    }
}
