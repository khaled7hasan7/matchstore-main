<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The admin panel is the first thing the owner sees after signing in, so a
 * page that throws there locks them out of their own store.
 */
class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function admin(): User
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@store.local',
            'password' => 'a-long-enough-password',
        ]);

        return $user->forceFill(['role' => User::ROLE_ADMIN]);
    }

    public function test_the_dashboard_opens_on_an_empty_store(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_the_dashboard_opens_with_orders_present(): void
    {
        // The dashboard summed orders.total_amount, a column that does not
        // exist, so every sign-in landed on a 500. An order has to be present
        // for this to bite under SQLite, which does not resolve the column
        // when the aggregate covers no rows — PostgreSQL rejects it either way.
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $productId = \Illuminate\Support\Facades\DB::table('products')->value('id');

        $orderId = \Illuminate\Support\Facades\DB::table('orders')->insertGetId([
            'first_name' => 'زبون', 'last_name' => 'تجريبي',
            'email' => 'buyer@example.test', 'phone' => '0790000000',
            'address' => 'عمّان', 'city' => 'عمّان', 'zipcode' => '11118', 'country' => 'Jordan',
            'payment_method' => 'cod', 'status' => 'completed',
            'subtotal' => 30, 'shipping_cost' => 3, 'discount' => 0, 'total' => 33,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        \Illuminate\Support\Facades\DB::table('order_details')->insert([
            'order_id' => $orderId, 'product_id' => $productId,
            'quantity' => 1, 'price' => 30,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('33', false);
    }

    public function test_the_catalogue_screens_open(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->actingAs($this->admin());

        foreach (['/admin/products', '/admin/categories', '/admin/brands', '/admin/orders',
            '/admin/banners', '/admin/promo-cards', '/admin/attributes', '/admin/site-settings'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_a_visitor_cannot_reach_the_admin_panel(): void
    {
        $this->get('/admin/dashboard')->assertRedirect();
    }
}
