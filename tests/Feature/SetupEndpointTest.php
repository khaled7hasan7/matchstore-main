<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Seeding from inside the running site, for when the build image has no PHP
 * binary and the database would otherwise never be updated at all.
 */
class SetupEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stays_hidden_when_no_token_is_configured(): void
    {
        $this->post('/__setup')->assertNotFound();
        $this->get('/__setup?token=anything')->assertNotFound();
    }

    public function test_a_wrong_token_is_refused(): void
    {
        putenv('SETUP_TOKEN=the-real-token');

        $this->post('/__setup?token=guess')->assertNotFound();

        putenv('SETUP_TOKEN');
    }

    public function test_a_get_asks_before_writing_anything(): void
    {
        putenv('SETUP_TOKEN=the-real-token');

        $this->get('/__setup?token=the-real-token')->assertOk();

        // Seeding is a write; a GET that something prefetches must not do it.
        $this->assertSame(0, DB::table('products')->count());

        putenv('SETUP_TOKEN');
    }

    public function test_a_post_seeds_the_store(): void
    {
        putenv('SETUP_TOKEN=the-real-token');

        $this->post('/__setup?token=the-real-token')
            ->assertOk()
            ->assertSee('OK');

        $catalog = require database_path('data/falak-catalog.php');
        $this->assertSame(count($catalog['products']), DB::table('products')->count());
        $this->assertDatabaseHas('site_settings', ['site_name' => 'Falak Store']);

        putenv('SETUP_TOKEN');
    }

    public function test_the_administrator_password_never_comes_back_in_the_response(): void
    {
        putenv('SETUP_TOKEN=the-real-token');
        putenv('ADMIN_EMAIL=owner@store.local');
        putenv('ADMIN_PASSWORD=a-password-nobody-should-see');

        $this->post('/__setup?token=the-real-token')
            ->assertOk()
            ->assertDontSee('a-password-nobody-should-see');

        $this->assertDatabaseHas('users', ['email' => 'owner@store.local']);

        putenv('SETUP_TOKEN');
        putenv('ADMIN_EMAIL');
        putenv('ADMIN_PASSWORD');
    }
}
