<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_administrator_who_can_sign_in(): void
    {
        $this->artisan('admin:create', ['email' => 'owner@store.local', '--password' => 'correct-horse-battery'])
            ->assertSuccessful();

        $user = User::where('email', 'owner@store.local')->firstOrFail();

        $this->assertSame(User::ROLE_ADMIN, $user->role);
        $this->assertTrue(Hash::check('correct-horse-battery', $user->password), 'The password must be usable for login');
        $this->assertTrue($user->isAdmin());
    }

    public function test_it_promotes_an_existing_user_without_duplicating_it(): void
    {
        User::create([
            'name' => 'Existing Person',
            'email' => 'owner@store.local',
            'password' => 'old-password-value',
        ]);

        $this->artisan('admin:create', ['email' => 'owner@store.local', '--password' => 'brand-new-password'])
            ->assertSuccessful();

        $this->assertSame(1, User::where('email', 'owner@store.local')->count());

        $user = User::where('email', 'owner@store.local')->firstOrFail();
        $this->assertSame('Existing Person', $user->name, 'An existing name should be kept');
        $this->assertSame(User::ROLE_ADMIN, $user->role);
        $this->assertTrue(Hash::check('brand-new-password', $user->password));
    }

    public function test_it_rejects_a_bad_email_and_a_short_password(): void
    {
        $this->artisan('admin:create', ['email' => 'not-an-email'])->assertFailed();
        $this->artisan('admin:create', ['email' => 'a@b.local', '--password' => 'short'])->assertFailed();

        $this->assertSame(0, User::count());
    }

    public function test_the_created_administrator_reaches_the_admin_panel(): void
    {
        $this->withoutVite();

        $this->artisan('admin:create', ['email' => 'owner@store.local', '--password' => 'correct-horse-battery']);

        $admin = User::where('email', 'owner@store.local')->firstOrFail();

        $this->actingAs($admin)->get('/admin/dashboard')->assertSuccessful();
    }
}
