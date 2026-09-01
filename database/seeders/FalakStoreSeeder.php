<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\SiteSetting;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Fills the store with Falak Store: a clothing shop with categories, house
 * labels, products in real colours and sizes, hero banners and promo cards.
 *
 * The catalogue itself lives in database/data/falak-catalog.php and the
 * artwork in public/images/catalog — shipped with the application because the
 * serverless host has a read-only filesystem, so nothing can be uploaded to it.
 */
class FalakStoreSeeder extends Seeder
{
    private const SHOP_SLUG = 'falak-store';

    private array $catalog;

    /** Dinars per stored unit — see baseAmount(). */
    private float $dinarRate = 1.0;

    public function run(): void
    {
        $this->catalog = require database_path('data/falak-catalog.php');
        $this->dinarRate = (float) (DB::table('currencies')->where('code', 'JOD')->value('exchange_rate') ?: 1.0);

        $vendor = Vendor::firstOrCreate(
            ['email' => 'store@falakstore.example'],
            [
                'name' => 'Falak Store',
                'password' => Hash::make(Str::password(16)),
                'status' => 'active',
            ]
        );

        // Inserted directly: the Shop model regenerates the slug from the
        // Arabic name on create, which would break idempotent re-runs.
        $shopId = DB::table('shops')->where('slug', self::SHOP_SLUG)->value('id');

        if (! $shopId) {
            $shopId = DB::table('shops')->insertGetId([
                'vendor_id' => $vendor->id,
                'name' => 'Falak Store',
                'slug' => self::SHOP_SLUG,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->retirePreviousCatalogue();
        $this->updateSiteSettings();

        $attributes = $this->seedAttributes();
        $categories = $this->seedCategories();
        $brands = $this->seedBrands();
        $this->seedBanners();
        $this->seedPromoCards();
        $this->seedCoupons();

        // The catalogue is built once. Re-seeding a live store must not delete
        // products customers have reviewed, wishlisted or ordered.
        if (DB::table('products')->where('shop_id', $shopId)->exists()) {
            $this->command->info('Falak Store: المنتجات موجودة مسبقاً، لم يُحذف أو يُضف شيء.');
        } else {
            $this->seedProducts($shopId, $vendor->id, $categories, $brands, $attributes);
            $this->command->info('Falak Store: تم تجهيز المتجر بنجاح.');
        }

        Cache::forget('site_settings');
    }

    /**
     * The shop opened as a bookstore before it became a clothing store, so a
     * database seeded then still holds the books. They are cleared out here —
     * but never once an order exists, because a sold product has to stay
     * around for the order history to make sense.
     */
    private function retirePreviousCatalogue(): void
    {
        $shopId = DB::table('shops')->where('slug', 'ibn-taymiyyah-bookstore')->value('id');

        if (! $shopId) {
            return;
        }

        if (DB::table('order_details')->exists()) {
            $this->command->warn('توجد طلبات سابقة — أُبقيت منتجات المكتبة كما هي حفاظاً على سجل الطلبات.');

            return;
        }

        $productIds = DB::table('products')->where('shop_id', $shopId)->pluck('id');

        if ($productIds->isNotEmpty()) {
            // Children first: no FK toggling, which is MySQL-only anyway.
            foreach ([
                'product_variant_attribute_values',
                'product_attribute_values',
                'product_images',
                'product_variants',
                'product_translations',
                'product_reviews',
                'wishlists',
            ] as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    DB::table($table)->whereIn('product_id', $productIds)->delete();
                }
            }

            DB::table('products')->whereIn('id', $productIds)->delete();
        }

        $vendorId = DB::table('shops')->where('id', $shopId)->value('vendor_id');
        DB::table('shops')->where('id', $shopId)->delete();

        if ($vendorId && ! DB::table('shops')->where('vendor_id', $vendorId)->exists()) {
            DB::table('vendors')->where('id', $vendorId)->delete();
        }

        $this->pruneEmptyTaxonomy();

        $this->command->info('Falak Store: أُزيل كتالوج المكتبة السابق.');
    }

    /**
     * Categories and publishers left behind by the previous catalogue. Only
     * those holding no products at all, so nothing in use is touched.
     */
    private function pruneEmptyTaxonomy(): void
    {
        $keepCategories = array_column($this->catalog['categories'], 'slug');
        $keepBrands = array_column($this->catalog['brands'], 'slug');

        $orphanCategories = DB::table('categories')
            ->whereNotIn('slug', $keepCategories)
            ->whereNotExists(fn ($query) => $query->select(DB::raw(1))
                ->from('products')
                ->whereColumn('products.category_id', 'categories.id'))
            ->pluck('id');

        if ($orphanCategories->isNotEmpty()) {
            DB::table('category_translations')->whereIn('category_id', $orphanCategories)->delete();
            DB::table('categories')->whereIn('id', $orphanCategories)->delete();
        }

        $orphanBrands = DB::table('brands')
            ->whereNotIn('slug', $keepBrands)
            ->whereNotExists(fn ($query) => $query->select(DB::raw(1))
                ->from('products')
                ->whereColumn('products.brand_id', 'brands.id'))
            ->pluck('id');

        if ($orphanBrands->isNotEmpty()) {
            DB::table('brand_translations')->whereIn('brand_id', $orphanBrands)->delete();
            DB::table('brands')->whereIn('id', $orphanBrands)->delete();
        }
    }

    private function updateSiteSettings(): void
    {
        $settings = SiteSetting::first() ?? new SiteSetting;
        $settings->fill([
            'site_name' => 'Falak Store',
            'tagline' => 'ملابس رجالية ونسائية وأطفال',
            'meta_title' => 'Falak Store — متجر الملابس',
            'meta_description' => 'Falak Store لبيع الملابس الرجالية والنسائية وملابس الأطفال والأحذية والحقائب والإكسسوارات، توصيل داخل الأردن وفلسطين.',
            'meta_keywords' => 'ملابس, أزياء, Falak Store, فلك ستور, ملابس رجالية, ملابس نسائية, ملابس أطفال, أحذية, حقائب',
            'contact_email' => 'info@falakstore.com',
            'footer_text' => '© '.date('Y').' Falak Store. جميع الحقوق محفوظة.',
            'logo' => '/images/catalog/falak-logo.svg',
            'default_currency' => 'JOD',
            'default_language' => 'ar',
        ]);
        $settings->save();
    }

    /**
     * Size and colour, with both languages, so the shop filters read in Arabic.
     *
     * @return array<string,array<string,int>> attribute name => value => id
     */
    private function seedAttributes(): array
    {
        $sizes = [];

        foreach ($this->catalog['products'] as $product) {
            foreach ($product['sizes'] as $value => $label) {
                $sizes[(string) $value] = $label;
            }
        }

        $colors = [];

        foreach ($this->catalog['colors'] as $key => $color) {
            $colors[$color['en']] = $color;
        }

        $map = [];

        // The shop filters look these up by the English attribute name.
        $map['Size'] = $this->seedAttributeValues('Size', array_map(
            fn ($value, $label) => ['value' => (string) $label, 'ar' => (string) $value, 'en' => (string) $label],
            array_keys($sizes),
            $sizes
        ));

        $map['Color'] = $this->seedAttributeValues('Color', array_map(
            fn ($color) => ['value' => $color['en'], 'ar' => $color['ar'], 'en' => $color['en']],
            array_values($colors)
        ));

        return $map;
    }

    /**
     * @param  array<int,array{value:string,ar:string,en:string}>  $values
     * @return array<string,int> value => attribute_value id
     */
    private function seedAttributeValues(string $name, array $values): array
    {
        $attributeId = DB::table('attributes')->where('name', $name)->value('id');

        if (! $attributeId) {
            $attributeId = DB::table('attributes')->insertGetId([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $map = [];

        foreach ($values as $value) {
            $valueId = DB::table('attribute_values')
                ->where('attribute_id', $attributeId)
                ->where('value', $value['value'])
                ->value('id');

            if (! $valueId) {
                $valueId = DB::table('attribute_values')->insertGetId([
                    'attribute_id' => $attributeId,
                    'value' => $value['value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach (['ar' => $value['ar'], 'en' => $value['en']] as $language => $translated) {
                DB::table('attribute_value_translations')->updateOrInsert(
                    ['attribute_value_id' => $valueId, 'language_code' => $language],
                    ['translated_value' => $translated, 'updated_at' => now(), 'created_at' => now()]
                );
            }

            $map[$value['value']] = $valueId;
        }

        return $map;
    }

    /** @return array<string,int> slug => category id */
    private function seedCategories(): array
    {
        $languages = $this->languages();
        $map = [];

        foreach ($this->catalog['categories'] as $category) {
            $model = Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['parent_category_id' => null, 'status' => true]
            );

            foreach ($languages as $language) {
                $model->translations()->updateOrCreate(
                    ['language_code' => $language],
                    [
                        'name' => $language === 'ar' ? $category['ar'] : $category['en'],
                        'description' => $language === 'ar' ? $category['description'] : $category['en'],
                        'image_url' => $category['image'],
                    ]
                );
            }

            $map[$category['slug']] = $model->id;
        }

        return $map;
    }

    /** @return array<string,int> slug => brand id */
    private function seedBrands(): array
    {
        $map = [];

        foreach ($this->catalog['brands'] as $brand) {
            // brands.status is an enum — a boolean passes on MySQL only
            $model = Brand::firstOrCreate(['slug' => $brand['slug']], ['status' => 'active']);

            foreach (['ar' => $brand['ar'], 'en' => $brand['en']] as $locale => $name) {
                $model->translations()->updateOrCreate(
                    ['locale' => $locale],
                    ['name' => $name, 'description' => $locale === 'ar' ? $brand['description'] : $brand['en']]
                );
            }

            $map[$brand['slug']] = $model->id;
        }

        return $map;
    }

    private function seedBanners(): void
    {
        foreach ($this->catalog['banners'] as $banner) {
            // banners carries no natural key, so the translated English title
            // is what identifies an already-seeded row.
            $bannerId = DB::table('banner_translations')
                ->where('language_code', 'en')
                ->where('title', $banner['en']['title'])
                ->value('banner_id');

            if (! $bannerId) {
                $bannerId = DB::table('banners')->insertGetId([
                    'title' => $banner['en']['title'],
                    'status' => 1,
                    'type' => 'promotion',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach (['ar', 'en'] as $language) {
                DB::table('banner_translations')->updateOrInsert(
                    ['banner_id' => $bannerId, 'language_code' => $language],
                    [
                        'title' => $banner[$language]['title'],
                        'description' => $banner[$language]['description'],
                        'image_url' => $banner['image'],
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    private function seedPromoCards(): void
    {
        foreach ($this->catalog['promo_cards'] as $card) {
            $cardId = DB::table('promo_card_translations')
                ->where('language_code', 'en')
                ->where('title', $card['en']['title'])
                ->value('promo_card_id');

            if (! $cardId) {
                $cardId = DB::table('promo_cards')->insertGetId([
                    'size' => $card['size'],
                    'order' => $card['order'],
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach (['ar', 'en'] as $language) {
                DB::table('promo_card_translations')->updateOrInsert(
                    ['promo_card_id' => $cardId, 'language_code' => $language],
                    [
                        'badge_text' => $card[$language]['badge_text'],
                        'title' => $card[$language]['title'],
                        'button_text' => $card[$language]['button_text'],
                        'button_url' => $card['button_url'],
                        'image_url' => $card['image'],
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * The discount codes the shop advertises. Kept idempotent on the code and
     * given a fresh expiry each run, so re-seeding never leaves the storefront
     * offering something the checkout will reject as expired.
     */
    private function seedCoupons(): void
    {
        foreach ($this->catalog['coupons'] as $coupon) {
            DB::table('coupons')->updateOrInsert(
                ['code' => $coupon['code']],
                [
                    'type' => $coupon['type'],
                    'discount' => $coupon['discount'],
                    'expires_at' => now()->addDays($coupon['valid_days']),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    /**
     * @param  array<string,int>  $categories
     * @param  array<string,int>  $brands
     * @param  array<string,array<string,int>>  $attributes
     */
    /**
     * The catalogue, written in batches rather than row by row.
     *
     * A product carries a translation per language, an image per colour and a
     * variant per colour/size pair — around 2,500 rows in total. Inserted one
     * at a time that is 2,500 round trips, which is unnoticeable against a
     * local database and minutes against a hosted one. Batching turns it into
     * roughly a dozen statements, which is what makes seeding possible inside
     * a request.
     *
     * @param  array<string,int>  $categories
     * @param  array<string,int>  $brands
     * @param  array<string,array<string,int>>  $attributes
     */
    private function seedProducts(int $shopId, int $vendorId, array $categories, array $brands, array $attributes): void
    {
        DB::transaction(function () use ($shopId, $vendorId, $categories, $brands, $attributes) {
            $now = now();

            $products = [];

            foreach ($this->catalog['products'] as $item) {
                $products[] = [
                    'shop_id' => $shopId,
                    'vendor_id' => $vendorId,
                    'category_id' => $categories[$item['category']],
                    'brand_id' => $brands[$item['brand']],
                    'product_type' => 'physical',
                    'status' => 1,
                    'slug' => $item['slug'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach (array_chunk($products, 200) as $chunk) {
                DB::table('products')->insert($chunk);
            }

            $productIds = DB::table('products')->where('shop_id', $shopId)->pluck('id', 'slug');

            $translations = $images = $variants = $productAttributes = [];

            foreach ($this->catalog['products'] as $item) {
                $productId = $productIds[$item['slug']];
                $colors = array_map(fn ($key) => $this->catalog['colors'][$key], $item['colors']);

                array_push($translations, ...$this->translationRows($productId, $item, $colors, $now));
                array_push($images, ...$this->imageRows($productId, $item, $now));
                array_push($variants, ...$this->variantRows($productId, $item, $now));
                array_push($productAttributes, ...$this->productAttributeRows($productId, $item, $attributes, $now));
            }

            foreach (array_chunk($translations, 200) as $chunk) {
                DB::table('product_translations')->insert($chunk);
            }

            foreach (array_chunk($images, 200) as $chunk) {
                DB::table('product_images')->insert($chunk);
            }

            foreach (array_chunk($variants, 200) as $chunk) {
                DB::table('product_variants')->insert($chunk);
            }

            foreach (array_chunk($productAttributes, 500) as $chunk) {
                DB::table('product_attribute_values')->insert($chunk);
            }

            $this->linkVariantAttributes($productIds, $attributes, $now);
        });
    }

    /** @return array<int,array<string,mixed>> */
    private function translationRows(int $productId, array $item, array $colors, $now): array
    {
        $arabicColors = implode('، ', array_column($colors, 'ar'));
        $englishColors = implode(', ', array_column($colors, 'en'));
        $sizes = implode(' · ', $item['sizes']);

        return [
            [
                'product_id' => $productId,
                'language_code' => 'ar',
                'name' => $item['ar'],
                'description' => $item['description']
                    .' متوفر بالألوان: '.$arabicColors.'. المقاسات: '.$sizes.'.',
                'short_description' => 'الألوان: '.$arabicColors,
                'tags' => 'ملابس, '.$item['ar'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $productId,
                'language_code' => 'en',
                'name' => $item['en'],
                'description' => $item['en'].'. Available in '.$englishColors.'. Sizes: '.$sizes.'.',
                'short_description' => 'Colors: '.$englishColors,
                'tags' => 'clothing, '.$item['en'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }

    /** @return array<int,array<string,mixed>> */
    private function imageRows(int $productId, array $item, $now): array
    {
        $rows = [];

        foreach ($item['colors'] as $index => $color) {
            $image = '/images/catalog/'.$item['shape'].'-'.$color.'.svg';

            // The first colour is the card thumbnail; the rest fill the gallery.
            $rows[] = [
                'product_id' => $productId,
                'name' => $item['slug'].'-'.$color,
                'image_url' => $image,
                'type' => $index === 0 ? 'thumb' : 'slide',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if ($index === 0) {
                $rows[] = [
                    'product_id' => $productId,
                    'name' => $item['slug'].'-'.$color.'-slide',
                    'image_url' => $image,
                    'type' => 'slide',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        return $rows;
    }

    /** @return array<int,array<string,mixed>> */
    private function variantRows(int $productId, array $item, $now): array
    {
        $rows = [];
        $sequence = 0;
        $first = true;
        $spread = count($item['colors']) * count($item['sizes']);

        foreach ($item['colors'] as $color) {
            foreach ($item['sizes'] as $size) {
                $sequence++;

                $rows[] = [
                    'product_id' => $productId,
                    'variant_slug' => $item['slug'].'-'.$color.'-'.Str::slug((string) $size),
                    'price' => $this->baseAmount($item['price']),
                    'discount_price' => $this->baseAmount($item['discount_price']),
                    // Spread the stock over the variants rather than giving
                    // every size the product's whole quantity.
                    'stock' => (int) max(1, round($item['stock'] / $spread)),
                    // Derived from the product id, not the slug: two slugs
                    // sharing their first characters produced the same SKU
                    // and the unique index rejected the second one mid-seed.
                    'SKU' => sprintf('FS-%04d-%02d', $productId, $sequence),
                    'weight' => 0.4,
                    'is_primary' => $first,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $first = false;
            }
        }

        return $rows;
    }

    /**
     * The colour and size pickers on the product page read the product-level
     * attribute values, not the per-variant ones, so a product needs both:
     * these rows are what makes the swatches and size buttons appear.
     *
     * @param array<string,array<string,int>> $attributes
     * @return array<int,array<string,mixed>>
     */
    private function productAttributeRows(int $productId, array $item, array $attributes, $now): array
    {
        $valueIds = [];

        foreach ($item['colors'] as $color) {
            $valueIds[] = $attributes['Color'][$this->catalog['colors'][$color]['en']] ?? null;
        }

        foreach ($item['sizes'] as $size) {
            $valueIds[] = $attributes['Size'][(string) $size] ?? null;
        }

        return array_map(fn ($valueId) => [
            'product_id' => $productId,
            'attribute_value_id' => $valueId,
            'created_at' => $now,
            'updated_at' => $now,
        ], array_values(array_filter($valueIds)));
    }

    /**
     * Ties each variant to its colour and size. Runs after the variants exist,
     * reading their ids back in one query rather than one per row.
     *
     * @param \Illuminate\Support\Collection<string,int> $productIds
     * @param array<string,array<string,int>> $attributes
     */
    private function linkVariantAttributes($productIds, array $attributes, $now): void
    {
        $variantIds = DB::table('product_variants')
            ->whereIn('product_id', $productIds->values())
            ->pluck('id', 'variant_slug');

        $rows = [];

        foreach ($this->catalog['products'] as $item) {
            $productId = $productIds[$item['slug']];

            foreach ($item['colors'] as $color) {
                foreach ($item['sizes'] as $size) {
                    $slug = $item['slug'].'-'.$color.'-'.Str::slug((string) $size);
                    $variantId = $variantIds[$slug] ?? null;

                    if (! $variantId) {
                        continue;
                    }

                    foreach ([
                        $attributes['Color'][$this->catalog['colors'][$color]['en']] ?? null,
                        $attributes['Size'][(string) $size] ?? null,
                    ] as $valueId) {
                        if ($valueId) {
                            $rows[] = [
                                'product_variant_id' => $variantId,
                                'attribute_value_id' => $valueId,
                                'product_id' => $productId,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('product_variant_attribute_values')->insert($chunk);
        }
    }

    /**
     * Prices in the catalogue are written in dinars, because that is what the
     * shop actually charges. The products table stores the base currency the
     * rest of the application converts from (currencies.exchange_rate is
     * "units per stored unit", and the admin forms convert on the way in), so
     * the dinar price is turned back into that base here — otherwise every
     * price on the storefront would be understated by the exchange rate.
     */
    private function baseAmount(?float $dinars): ?float
    {
        if ($dinars === null) {
            return null;
        }

        return $this->dinarRate > 0 ? round($dinars / $this->dinarRate, 2) : $dinars;
    }

    /** @return array<int,string> */
    private function languages(): array
    {
        $languages = Language::where('active', 1)->pluck('code')->all();

        return $languages ?: ['ar', 'en'];
    }
}
