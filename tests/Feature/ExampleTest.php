<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Smoke test: the app boots, migrations run and a public JSON
     * endpoint responds without any seeded data.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/shipping/regions/jordan');

        $response->assertOk()->assertJson(['success' => true]);
    }
}
