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
        'categories', 'brands', 'shipping_regions', 'payment_gateways',
        'payment_gateway_configs', 'menus', 'menu_items', 'pages',
        'site_settings', 'shops', 'vendors', 'languages',
    ];

    public function test_seeding_produces_a_complete_bookstore(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(22, DB::table('products')->count(), 'every book must be seeded');
        $this->assertSame(22, DB::table('product_variants')->count(), 'each book needs a purchasable variant');
        $this->assertSame(44, DB::table('product_translations')->count(), 'each book needs both languages');
        $this->assertSame(8, DB::table('categories')->count());
        $this->assertSame(5, DB::table('brands')->count(), 'the publishers');
        $this->assertSame(27, DB::table('shipping_regions')->count(), 'Jordan and Palestine');
        $this->assertSame(2, DB::table('languages')->where('active', true)->count());

        $this->assertDatabaseHas('site_settings', [
            'site_name' => 'مكتبة ابن تيمية',
            'default_currency' => 'JOD',
            'default_language' => 'ar',
        ]);
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
            'name' => 'قارئ',
            'email' => 'reader@example.test',
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
