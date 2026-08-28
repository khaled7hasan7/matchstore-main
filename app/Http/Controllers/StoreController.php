<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromoCard;

class StoreController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        // Get all active banners with translations
        // If current language translation doesn't exist, fall back to default language (en)
        $banners = Banner::where('status', 1)
            ->with(['translation', 'translations' => function ($q) {
                $q->where('language_code', 'en');
            }])
            ->orderBy('id', 'desc')
            ->take(3)
            ->get()
            ->map(function ($banner) use ($locale) {
                // If translation doesn't exist for current language, use the first available translation
                if (!$banner->translation && $banner->translations->isNotEmpty()) {
                    $banner->setRelation('translation', $banner->translations->first());
                }
                return $banner;
            });

        $categories = Category::where('status', 1)
            ->with('translation')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $products = Product::where('status', 1)
            ->with(['translation', 'thumbnail', 'images', 'primaryVariant'])
            ->withCount('reviews')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        // Get active promo cards with translations
        $promoCards = PromoCard::where('status', 1)
            ->with(['translation', 'translations' => function ($q) {
                $q->where('language_code', 'en');
            }])
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($card) use ($locale) {
                // If translation doesn't exist for current language, use the first available translation
                if (!$card->translation && $card->translations->isNotEmpty()) {
                    $card->setRelation('translation', $card->translations->first());
                }
                return $card;
            });

        return view('themes.xylo.home', compact('banners', 'categories', 'products', 'promoCards'));
    }
}
