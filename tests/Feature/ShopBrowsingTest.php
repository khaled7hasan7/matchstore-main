<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\Shop;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShopBrowsingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $vendor = Vendor::create([
            'name' => 'Vendor',
            'email' => 'vendor@test.local',
            'password' => 'secret-password',
            'status' => 'active',
        ]);

        $shop = new Shop(['name' => 'Shop', 'slug' => 'shop']);
        $shop->vendor_id = $vendor->id;
        $shop->save();

        DB::table('categories')->insert([
            'slug' => 'books',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'exchange_rate' => 1.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Three products: prices 30 / 10 / 20, names Gamma / Alpha / Beta,
        // the 10-priced one out of stock.
        foreach ([
            ['slug' => 'gamma-book', 'name' => 'Gamma Book', 'price' => 30, 'stock' => 5],
            ['slug' => 'alpha-book', 'name' => 'Alpha Book', 'price' => 10, 'stock' => 0],
            ['slug' => 'beta-book', 'name' => 'Beta Book', 'price' => 20, 'stock' => 3],
        ] as $i => $data) {
            $product = Product::create([
                'shop_id' => $shop->id,
                'vendor_id' => $vendor->id,
                'slug' => $data['slug'],
                'category_id' => 1,
                'product_type' => 'simple',
                'status' => 1,
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'language_code' => 'en',
                'name' => $data['name'],
            ]);

            ProductVariant::create([
                'product_id' => $product->id,
                'variant_slug' => $data['slug'].'-default',
                'price' => $data['price'],
                'stock' => $data['stock'],
                'SKU' => 'SKU-'.$i,
                'is_primary' => true,
            ]);
        }
    }

    protected function shop(array $query): \Illuminate\Testing\TestResponse
    {
        return $this->get('/shop?'.http_build_query($query), ['X-Requested-With' => 'XMLHttpRequest']);
    }

    public function test_sort_by_lowest_price_ascending(): void
    {
        $this->shop(['sort' => 'price_low'])
            ->assertOk()
            ->assertSeeInOrder(['Alpha Book', 'Beta Book', 'Gamma Book']);
    }

    public function test_sort_by_lowest_price_descending(): void
    {
        $this->shop(['sort' => 'price_high'])
            ->assertOk()
            ->assertSeeInOrder(['Gamma Book', 'Beta Book', 'Alpha Book']);
    }

    public function test_sort_by_translated_name(): void
    {
        $this->shop(['sort' => 'name_asc'])
            ->assertOk()
            ->assertSeeInOrder(['Alpha Book', 'Beta Book', 'Gamma Book']);
    }

    public function test_in_stock_filter_hides_out_of_stock_products(): void
    {
        $this->shop(['in_stock' => 1])
            ->assertOk()
            ->assertSee('Beta Book')
            ->assertSee('Gamma Book')
            ->assertDontSee('Alpha Book');
    }

    public function test_rating_filter_query_executes(): void
    {
        $customer = \App\Models\Customer::create([
            'name' => 'Reader',
            'email' => 'reader@test.local',
            'password' => 'secret-password',
        ]);

        ProductReview::create([
            'customer_id' => $customer->id,
            'product_id' => Product::where('slug', 'gamma-book')->value('id'),
            'rating' => 5,
            'review' => 'Great',
            'is_approved' => 1,
        ]);

        $this->shop(['rating' => 4])
            ->assertOk()
            ->assertSee('Gamma Book')
            ->assertDontSee('Beta Book');
    }

    public function test_search_suggestions_are_case_insensitive(): void
    {
        $response = $this->getJson('/search-suggestions?q=alpha&locale=en');

        $response->assertOk();
        $this->assertCount(1, $response->json());
        $this->assertEquals('Alpha Book', $response->json()[0]['name']);
    }
}
