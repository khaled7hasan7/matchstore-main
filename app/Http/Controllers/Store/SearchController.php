<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->input('q');
        $locale = $request->input('locale', App::getLocale());

        $products = Product::whereHas('translations', function ($q) use ($query, $locale) {
            $q->whereLike('name', "%{$query}%")->where('language_code', $locale);
        })
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('language_code', $locale)->select('product_id', 'name');
                },
                'thumbnail',
            ])
            ->limit(10)
            ->get(['id', 'slug']);

        $products = $products->map(function ($product) {
            $imageUrl = $product->thumbnail ? $product->thumbnail->image_url : 'default-thumbnail.jpg';
            $isExternal = str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://');
            $finalImageUrl = $isExternal ? $imageUrl : asset('storage/' . $imageUrl);

            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'thumbnail' => $finalImageUrl,
                'name' => $product->translations->first()->name ?? null,
            ];
        });

        return response()->json($products);
    }

    public function searchResults(Request $request)
    {
        $query = $request->input('q');
        $locale = $request->input('locale', App::getLocale());

        $products = Product::whereHas('translations', function ($q) use ($query, $locale) {
            $q->whereLike('name', "%{$query}%")->where('language_code', $locale);
        })
            ->with([
                'translations' => function ($q) use ($locale) {
                    $q->where('language_code', $locale)->select('product_id', 'name', 'description');
                },
                'thumbnail',
            ])
            ->paginate(10);

        return view('search-results', compact('products', 'query'));
    }
}
