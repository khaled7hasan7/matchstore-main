<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The storefront must survive a freshly migrated, unseeded database —
 * that is the state of a brand new production deployment.
 */
class EmptyDatabaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_active_currency_falls_back_instead_of_returning_null(): void
    {
        // Migrations alone leave no USD row, yet USD is the default session
        // currency — this combination returned null and fataled every page.
        $this->assertNull(Currency::where('code', 'USD')->first());

        $currency = activeCurrency();

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame('$', $currency->symbol);
        $this->assertFalse($currency->exists, 'The fallback must not be a persisted row');
    }

    public function test_active_currency_prefers_a_real_row_over_the_fallback(): void
    {
        // JOD is inserted by the currency data migrations
        session(['currency' => 'JOD']);

        $currency = activeCurrency();

        $this->assertTrue($currency->exists, 'A persisted row must win over the fallback');
        $this->assertSame('JOD', $currency->code);
    }

    public function test_homepage_renders_without_any_seeded_data(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_shop_page_renders_without_any_seeded_data(): void
    {
        $this->get('/shop')->assertOk();
    }
}
