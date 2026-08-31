<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The seeders are what turns a freshly migrated database into a usable
 * store, so they have to produce a complete catalogue, invent no sales
 * history, and be safe to run again on a store that is already live.
 */
class DatabaseSeedingTest extends TestCase
{
    use RefreshDatabase;

    /** Tables whose contents must be identical after a second seed run. */
    private const CATALOGUE_TABLES = [
        'products', 'product_variants', 'product_translations', 'product_images',
        'product_attribute_values', 'product_variant_attribute_values',
        'categories', 'brands', 'attributes', 'attribute_values',
        'shipping_regions', 'payment_gateways', 'payment_gateway_configs',
        'banners', 'promo_cards', 'menus', 'menu_items', 'pages',
        'site_settings', 'shops', 'vendors', 'languages',
    ];

    public function test_seeding_produces_a_complete_store(): void
    {
        $this->seed(DatabaseSeeder::class);

        $catalog = require database_path('data/falak-catalog.php');

        $this->assertSame(count($catalog['products']), DB::table('products')->count());
        $this->assertSame(count($catalog['categories']), DB::table('categories')->count());
        $this->assertSame(count($catalog['brands']), DB::table('brands')->count());
        $this->assertSame(count($catalog['banners']), DB::table('banners')->count());
        $this->assertSame(count($catalog['promo_cards']), DB::table('promo_cards')->count());
        $this->assertSame(27, DB::table('shipping_regions')->count(), 'Jordan and Palestine');
        $this->assertSame(2, DB::table('languages')->where('active', true)->count());

        $this->assertDatabaseHas('site_settings', [
            'site_name' => 'فلك ستور',
            'default_currency' => 'JOD',
            'default_language' => 'ar',
        ]);
    }

    public function test_every_product_is_purchasable_and_shown(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (DB::table('products')->pluck('id') as $productId) {
            $this->assertSame(2, DB::table('product_translations')->where('product_id', $productId)->count(),
                'both languages');
            $this->assertSame(1, DB::table('product_images')->where('product_id', $productId)->where('type', 'thumb')->count(),
                'exactly one card thumbnail');
            $this->assertGreaterThan(0, DB::table('product_variants')->where('product_id', $productId)->count());
            $this->assertSame(1, DB::table('product_variants')->where('product_id', $productId)->where('is_primary', true)->count(),
                'exactly one primary variant');
            // Without these the product page renders no colour or size picker.
            $this->assertGreaterThan(0, DB::table('product_attribute_values')->where('product_id', $productId)->count());
        }
    }

    public function test_every_seeded_image_is_shipped_with_the_application(): void
    {
        $this->seed(DatabaseSeeder::class);

        $urls = DB::table('product_images')->pluck('image_url')
            ->merge(DB::table('category_translations')->pluck('image_url'))
            ->merge(DB::table('banner_translations')->pluck('image_url'))
            ->merge(DB::table('promo_card_translations')->pluck('image_url'))
            ->push(DB::table('site_settings')->value('logo'))
            ->filter()
            ->unique();

        $this->assertNotEmpty($urls);

        foreach ($urls as $url) {
            // The serverless host cannot be uploaded to, so nothing may point
            // at storage — every image has to exist in public/.
            $this->assertStringStartsWith('/images/', $url);
            $this->assertFileExists(public_path(ltrim($url, '/')), $url.' is referenced but not shipped');
        }
    }

    public function test_prices_are_stored_so_they_display_as_written(): void
    {
        $this->seed(DatabaseSeeder::class);

        $catalog = require database_path('data/falak-catalog.php');
        $rate = (float) DB::table('currencies')->where('code', 'JOD')->value('exchange_rate');

        foreach ($catalog['products'] as $item) {
            $variant = DB::table('product_variants')
                ->join('products', 'products.id', '=', 'product_variants.product_id')
                ->where('products.slug', $item['slug'])
                ->first(['product_variants.price', 'product_variants.discount_price']);

            $this->assertEqualsWithDelta($item['price'], round($variant->price * $rate, 2), 0.005,
                $item['slug'].' must show the dinar price from the catalogue');

            if ($item['discount_price'] !== null) {
                $this->assertEqualsWithDelta($item['discount_price'], round($variant->discount_price * $rate, 2), 0.005);
            }
        }
    }

    public function test_only_cash_on_delivery_is_switched_on(): void
    {
        $this->seed(DatabaseSeeder::class);

        // The others carry placeholder credentials; leaving them active would
        // offer the customer a checkout that cannot complete.
        $this->assertDatabaseHas('payment_gateways', ['code' => 'cod', 'is_active' => true]);
        $this->assertDatabaseHas('payment_gateways', ['code' => 'paypal', 'is_active' => false]);
        $this->assertDatabaseHas('payment_gateways', ['code' => 'stripe', 'is_active' => false]);
    }

    public function test_seeding_invents_no_sales_history(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (['orders', 'order_details', 'payments', 'refunds', 'customers'] as $table) {
            $this->assertSame(0, DB::table($table)->count(), "{$table} must start empty");
        }
    }

    public function test_seeding_twice_changes_nothing(): void
    {
        $this->seed(DatabaseSeeder::class);
        $before = $this->catalogueCounts();

        $this->seed(DatabaseSeeder::class);

        $this->assertSame($before, $this->catalogueCounts(), 'a second run must not duplicate or delete rows');
    }

    public function test_reseeding_keeps_customer_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $product = DB::table('products')->first();
        $customerId = DB::table('customers')->insertGetId([
            'name' => 'زبون',
            'email' => 'shopper@example.test',
            'password' => bcrypt('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('wishlists')->insert([
            'customer_id' => $customerId,
            'product_id' => $product->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->seed(DatabaseSeeder::class);

        // Re-seeding used to wipe the catalogue, taking wishlists and reviews
        // with it. Those belong to customers, not to the seeder.
        $this->assertDatabaseHas('wishlists', ['product_id' => $product->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    /** @return array<string,int> */
    private function catalogueCounts(): array
    {
        $counts = [];

        foreach (self::CATALOGUE_TABLES as $table) {
            $counts[$table] = DB::table($table)->count();
        }

        return $counts;
    }
}
