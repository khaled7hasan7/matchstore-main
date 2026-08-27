<?php

namespace Tests\Feature;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderConfirmationMail;
use App\Mail\VendorOrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\ShippingRegion;
use App\Models\Shop;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    protected ProductVariant $variant;

    protected ShippingRegion $region;

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

        $shop = new Shop(['name' => 'Test Shop', 'slug' => 'test-shop']);
        $shop->vendor_id = $vendor->id;
        $shop->save();

        DB::table('categories')->insert([
            'slug' => 'books',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->product = Product::create([
            'shop_id' => $shop->id,
            'vendor_id' => $vendor->id,
            'slug' => 'test-book',
            'category_id' => 1,
            'product_type' => 'simple',
            'status' => 1,
        ]);

        ProductTranslation::create([
            'product_id' => $this->product->id,
            'language_code' => 'en',
            'name' => 'Test Book',
        ]);

        $this->variant = ProductVariant::create([
            'product_id' => $this->product->id,
            'variant_slug' => 'test-book-default',
            'price' => 20.00,
            'stock' => 5,
            'SKU' => 'BOOK-1',
            'is_primary' => true,
        ]);

        $this->region = ShippingRegion::create([
            'country' => 'jordan',
            'name' => 'Amman',
            'name_ar' => 'عمّان',
            'code' => 'JO_AMMAN',
            'region_type' => 'governorate',
            'base_cost' => 3.00,
            'per_kg_cost' => 0.50,
            'delivery_days' => 2,
            'is_active' => true,
        ]);

        DB::table('payment_gateways')->insert([
            'name' => 'Cash on Delivery',
            'code' => 'cod',
            'description' => 'COD',
            'is_active' => true,
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
    }

    protected function addToCart(int $quantity = 1): void
    {
        $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => $quantity,
        ])->assertOk();
    }

    protected function checkoutPayload(array $overrides = []): array
    {
        return array_merge([
            'gateway' => 'cod',
            'first_name' => 'Khaled',
            'last_name' => 'Hasan',
            'address' => '12 Main Street',
            'country' => 'jordan',
            'region_id' => $this->region->id,
            'city' => 'Amman',
            'zipcode' => '11118',
            'email' => 'guest@test.local',
            'phone' => '0790000000',
        ], $overrides);
    }

    public function test_cod_checkout_stores_totals_shipping_and_reserves_stock(): void
    {
        $this->addToCart(2);

        Coupon::create([
            'code' => 'SAVE10',
            'discount' => 10,
            'type' => 'percentage',
            'expires_at' => now()->addDay(),
        ]);
        $this->post(route('cart.applyCoupon'), ['code' => 'SAVE10'])->assertOk();

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $order = Order::first();
        $this->assertNotNull($order, 'COD checkout should create an order');
        $response->assertRedirect(route('order.confirmation', ['orderId' => $order->id]));

        // 2 × 20.00 = 40.00 subtotal, 10% coupon = 4.00, Amman base cost 3.00
        $this->assertEquals(40.00, (float) $order->subtotal);
        $this->assertEquals(4.00, (float) $order->discount);
        $this->assertEquals('SAVE10', $order->coupon_code);
        $this->assertEquals(3.00, (float) $order->shipping_cost);
        $this->assertEquals(39.00, (float) $order->total);
        $this->assertEquals($this->region->id, $order->region_id);
        $this->assertEquals('cod', $order->payment_method);

        $this->assertEquals(3, $this->variant->fresh()->stock, 'Stock should be reserved');
        $this->assertSame(1, $order->details()->count());
        $this->assertEmpty(session('cart', []), 'Cart should be cleared after checkout');
        $this->assertNull(session('cart_coupon'), 'Coupon should be cleared after checkout');
    }

    public function test_checkout_rolls_back_when_stock_is_insufficient(): void
    {
        $this->addToCart(2);
        $this->variant->update(['stock' => 1]);

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertSame(0, Order::count(), 'No order should survive a stock failure');
        $this->assertEquals(1, $this->variant->fresh()->stock, 'Stock must be untouched on rollback');
    }

    public function test_coupon_expired_after_apply_is_rejected_at_checkout(): void
    {
        $this->addToCart(1);

        $coupon = Coupon::create([
            'code' => 'LATE',
            'discount' => 50,
            'type' => 'percentage',
            'expires_at' => now()->addDay(),
        ]);
        $this->post(route('cart.applyCoupon'), ['code' => 'LATE'])->assertOk();

        $coupon->update(['expires_at' => now()->subDay()]);

        $this->post(route('checkout.process'), $this->checkoutPayload())
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame(0, Order::count());
        $this->assertEquals(5, $this->variant->fresh()->stock);
    }

    public function test_checkout_rejects_inactive_shipping_region(): void
    {
        $this->addToCart(1);
        $this->region->update(['is_active' => false]);

        $this->post(route('checkout.process'), $this->checkoutPayload())
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame(0, Order::count());
    }

    public function test_guest_confirmation_is_scoped_to_the_ordering_session(): void
    {
        $this->addToCart(1);
        $this->post(route('checkout.process'), $this->checkoutPayload());

        $order = Order::first();

        // The guest who placed the order can view it
        $this->get(route('order.confirmation', ['orderId' => $order->id]))->assertOk();

        // A different session cannot
        $this->flushSession();
        $this->get(route('order.confirmation', ['orderId' => $order->id]))->assertForbidden();
    }

    public function test_admin_cancellation_restocks_and_requires_admin_role(): void
    {
        $this->addToCart(2);
        $this->post(route('checkout.process'), $this->checkoutPayload());

        $order = Order::first();
        $this->assertEquals(3, $this->variant->fresh()->stock);

        $user = User::create([
            'name' => 'Regular',
            'email' => 'user@test.local',
            'password' => 'secret-password',
        ]);

        $this->actingAs($user)
            ->patch(route('admin.orders.update-status', $order->id), ['status' => 'canceled'])
            ->assertForbidden();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.local',
            'password' => 'secret-password',
        ]);
        $admin->forceFill(['role' => User::ROLE_ADMIN])->save();

        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $order->id), ['status' => 'canceled'])
            ->assertRedirect();

        $this->assertEquals('canceled', $order->fresh()->status);
        $this->assertEquals(5, $this->variant->fresh()->stock, 'Canceling must return reserved stock');

        // Cancelling twice must not restock twice
        $this->actingAs($admin)
            ->patch(route('admin.orders.update-status', $order->id), ['status' => 'canceled'])
            ->assertRedirect();
        $this->assertEquals(5, $this->variant->fresh()->stock);
    }

    public function test_empty_cart_cannot_checkout(): void
    {
        $this->post(route('checkout.process'), $this->checkoutPayload())
            ->assertRedirect(route('cart.view'));

        $this->assertSame(0, Order::count());
    }

    public function test_order_emails_are_queued_to_customer_admin_and_vendor(): void
    {
        Mail::fake();

        SiteSetting::create([
            'site_name' => 'مكتبة ابن تيمية',
            'contact_email' => 'admin@store.local',
        ]);

        $this->addToCart(1);
        $this->post(route('checkout.process'), $this->checkoutPayload());

        $this->assertNotNull(Order::first());

        Mail::assertQueued(OrderConfirmationMail::class, fn ($mail) => $mail->hasTo('guest@test.local'));
        Mail::assertQueued(NewOrderAdminMail::class, fn ($mail) => $mail->hasTo('admin@store.local'));
        Mail::assertQueued(VendorOrderMail::class, fn ($mail) => $mail->hasTo('vendor@test.local'));
    }

    public function test_order_emails_render_with_items_and_totals(): void
    {
        $this->addToCart(2);
        $this->post(route('checkout.process'), $this->checkoutPayload());

        $order = Order::first();
        $order->load(['details.product.translations', 'details.product.vendor', 'region']);

        $confirmation = (new OrderConfirmationMail($order, '$', 'Test Store'))->render();
        $this->assertStringContainsString('Test Book', $confirmation);
        $this->assertStringContainsString('Amman', $confirmation);
        $this->assertStringContainsString(number_format($order->total, 2), $confirmation);

        $admin = (new NewOrderAdminMail($order, '$', 'Test Store'))->render();
        $this->assertStringContainsString('Test Book', $admin);
        $this->assertStringContainsString($order->email, $admin);

        $vendorMail = (new VendorOrderMail($order, Vendor::first(), $order->details, '$', 'Test Store'))->render();
        $this->assertStringContainsString('Test Book', $vendorMail);
        $this->assertStringContainsString(number_format($order->subtotal, 2), $vendorMail);
    }

    public function test_mail_failure_does_not_break_checkout(): void
    {
        // No SMTP is configured and the mailer will fail hard — the order
        // must still be placed and the customer redirected normally.
        config(['mail.default' => 'smtp', 'mail.mailers.smtp.host' => 'invalid.host.test', 'mail.mailers.smtp.timeout' => 1]);

        $this->addToCart(1);

        $response = $this->post(route('checkout.process'), $this->checkoutPayload());

        $order = Order::first();
        $this->assertNotNull($order, 'Order must survive mail failure');
        $response->assertRedirect(route('order.confirmation', ['orderId' => $order->id]));
    }
}
