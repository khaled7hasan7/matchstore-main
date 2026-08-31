<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $filters = [
            'category' => array_filter((array) $request->input('category', [])),
            'brand' => array_filter((array) $request->input('brand', [])),
            'price_min' => $request->input('price_min'),
            'price_max' => $request->input('price_max'),
            'color' => array_filter((array) $request->input('color', [])),
            'size' => array_filter((array) $request->input('size', [])),
            'in_stock' => $request->input('in_stock'),
            'rating' => $request->input('rating'),
            'sort' => $request->input('sort', 'default'),
        ];

        // Get dynamic price range from actual products
        $priceRange = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->selectRaw('MIN(product_variants.price) as min_price, MAX(product_variants.price) as max_price')
            ->first();

        // Set default price range if not provided
        if (!$filters['price_min']) {
            $filters['price_min'] = floor($priceRange->min_price ?? 0);
        }
        if (!$filters['price_max']) {
            $filters['price_max'] = ceil($priceRange->max_price ?? 1000);
        }

        $query = Product::with(['translation', 'thumbnail', 'primaryVariant', 'variants.attributeValues', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when(! empty($filters['category']), function ($query) use ($filters) {
                $query->whereIn('category_id', $filters['category']);
            })
            ->when(! empty($filters['brand']), function ($query) use ($filters) {
                $query->whereIn('brand_id', $filters['brand']);
            })
            ->when($filters['rating'], function ($query) use ($filters) {
                // Correlated average subquery: whereHas + groupBy/having emits
                // SELECT * with GROUP BY, which PostgreSQL rejects. The int
                // cast matters too — PDO sends strings as text and SQLite
                // won't coerce text against the affinity-less AVG() result.
                $query->where(
                    ProductReview::selectRaw('AVG(rating)')
                        ->whereColumn('product_id', 'products.id')
                        ->where('is_approved', 1),
                    '>=',
                    (int) $filters['rating']
                );
            })
            ->whereHas('variants', function ($variantQuery) use ($filters) {
                $variantQuery
                    ->when($filters['price_min'], function ($q) use ($filters) {
                        $q->where('price', '>=', $filters['price_min']);
                    })
                    ->when($filters['price_max'], function ($q) use ($filters) {
                        $q->where('price', '<=', $filters['price_max']);
                    })
                    ->when($filters['in_stock'], function ($q) {
                        $q->where('stock', '>', 0);
                    })
                    ->when(! empty($filters['color']), function ($q) use ($filters) {
                        $q->whereHas('attributeValues', function ($avQuery) use ($filters) {
                            $avQuery->whereIn('value', $filters['color'])
                                ->whereHas('attribute', function ($aQuery) {
                                    $aQuery->where('name', 'Color');
                                });
                        });
                    })
                    ->when(! empty($filters['size']), function ($q) use ($filters) {
                        $q->whereHas('attributeValues', function ($avQuery) use ($filters) {
                            $avQuery->whereIn('value', $filters['size'])
                                ->whereHas('attribute', function ($aQuery) {
                                    $aQuery->where('name', 'Size');
                                });
                        });
                    });
            });

        // Apply sorting. Price sorting uses a correlated subquery instead of
        // join + groupBy + orderByRaw(MIN(...)), which PostgreSQL rejects and
        // which duplicated rows on MySQL.
        $lowestVariantPrice = ProductVariant::select('price')
            ->whereColumn('product_id', 'products.id')
            ->orderBy('price')
            ->limit(1);

        switch ($filters['sort']) {
            case 'price_low':
                $query->orderBy($lowestVariantPrice);
                break;
            case 'price_high':
                $query->orderByDesc($lowestVariantPrice);
                break;
            case 'newest':
                $query->orderBy('created_at', 'DESC');
                break;
            case 'rating':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'name_asc':
                // products has no name column — the name lives on the translation
                $query->orderBy(
                    ProductTranslation::select('name')
                        ->whereColumn('product_id', 'products.id')
                        ->where('language_code', $locale)
                        ->limit(1)
                );
                break;
            default:
                $query->orderBy('created_at', 'DESC');
        }

        $products = $query->paginate(12);

        $brands = Brand::with('translation')->withCount('products')->get();
        $categories = Category::with('translation')->withCount('products')->get();

        // Get dynamic available colors from product variants
        $availableColors = \DB::table('product_variant_attribute_values')
            ->join('attribute_values', 'product_variant_attribute_values.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->where('attributes.name', 'Color')
            ->distinct()
            ->pluck('attribute_values.value')
            ->toArray();

        // Get dynamic available sizes from product variants
        $availableSizes = \DB::table('product_variant_attribute_values')
            ->join('attribute_values', 'product_variant_attribute_values.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->where('attributes.name', 'Size')
            ->distinct()
            ->pluck('attribute_values.value')
            ->toArray();

        if ($request->ajax()) {
            return view('themes.xylo.partials.product-list', compact('products'))->render();
        }

        return view('themes.xylo.shop', compact(
            'products',
            'categories',
            'brands',
            'availableColors',
            'availableSizes',
            'priceRange',
            'filters'
        ));
    }
}
