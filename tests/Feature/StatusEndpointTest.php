<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The endpoint that answers "why has the deployed site not changed?".
 */
class StatusEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reports_what_the_database_holds(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->getJson('/__status')
            ->assertOk()
            ->assertJsonPath('database.connected', true)
            ->assertJsonPath('database.site_name', 'Falak Store')
            ->assertJsonPath('database.counts.products', 64)
            ->assertJsonStructure(['app' => ['commit', 'branch'], 'database' => ['counts'], 'uploads']);
    }

    public function test_it_reports_an_empty_database_rather_than_failing(): void
    {
        // A migrated but unseeded database is exactly the state that makes a
        // deployment look like it "did not update".
        $this->getJson('/__status')
            ->assertOk()
            ->assertJsonPath('database.connected', true)
            ->assertJsonPath('database.counts.products', 0)
            ->assertJsonPath('database.site_name', null);
    }

    public function test_it_keeps_connection_details_behind_a_token(): void
    {
        $response = $this->getJson('/__status')->assertOk();

        $this->assertArrayNotHasKey('host', $response->json('database'));
        $this->assertArrayNotHasKey('name', $response->json('database'));
    }
}
