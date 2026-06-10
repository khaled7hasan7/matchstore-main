<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\PromoCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $languages = Language::where('active', 1)->get();

            $promoCards = [
                [
                    'size' => 'large',
                    'order' => 1,
                    'status' => 1,
                    'translations' => [
                        'en' => [
                            'badge_text' => 'Summer Sale',
                            'title' => 'Up to 50% Off',
                            'button_text' => 'Shop Now',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800',
                        ],
                        'ar' => [
                            'badge_text' => 'تخفيضات الصيف',
                            'title' => 'خصم يصل إلى 50%',
                            'button_text' => 'تسوق الآن',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800',
                        ],
                    ],
                ],
                [
                    'size' => 'small',
                    'order' => 2,
                    'status' => 1,
                    'translations' => [
                        'en' => [
                            'badge_text' => 'New Arrivals',
                            'title' => 'Latest Collection',
                            'button_text' => 'Discover',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800',
                        ],
                        'ar' => [
                            'badge_text' => 'وصل حديثاً',
                            'title' => 'أحدث المجموعات',
                            'button_text' => 'اكتشف',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800',
                        ],
                    ],
                ],
                [
                    'size' => 'small',
                    'order' => 3,
                    'status' => 1,
                    'translations' => [
                        'en' => [
                            'badge_text' => 'Trending',
                            'title' => 'Best Sellers',
                            'button_text' => 'Explore',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800',
                        ],
                        'ar' => [
                            'badge_text' => 'رائج',
                            'title' => 'الأكثر مبيعاً',
                            'button_text' => 'استكشف',
                            'button_url' => '/shop',
                            'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800',
                        ],
                    ],
                ],
            ];

            foreach ($promoCards as $cardData) {
                $card = PromoCard::create([
                    'size' => $cardData['size'],
                    'order' => $cardData['order'],
                    'status' => $cardData['status'],
                ]);

                foreach ($languages as $lang) {
                    $translation = $cardData['translations'][$lang->code] ?? $cardData['translations']['en'];

                    $card->translations()->create([
                        'language_code' => $lang->code,
                        'badge_text' => $translation['badge_text'],
                        'title' => $translation['title'],
                        'button_text' => $translation['button_text'],
                        'button_url' => $translation['button_url'],
                        'image_url' => $translation['image_url'],
                    ]);
                }
            }
        });
    }
}
