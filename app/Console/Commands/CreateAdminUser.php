<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {email : Email address for the administrator}
                            {--name= : Display name (defaults to Administrator)}
                            {--password= : Use this password instead of generating one}';

    protected $description = 'Create an administrator account, or promote an existing user and reset its password.';

    public function handle(): int
    {
        $email = trim((string) $this->argument('email'));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Not a valid email address: {$email}");

            return self::FAILURE;
        }

        $password = (string) ($this->option('password') ?: Str::password(16));

        if (mb_strlen($password) < 8) {
            $this->error('The password must be at least 8 characters.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $existed = $user->exists;

        $user->name = $this->option('name') ?: ($user->name ?: 'Administrator');
        // The model casts "password" as hashed, so assign the plain value.
        $user->password = $password;
        $user->save();

        // role is intentionally not mass assignable
        $user->forceFill(['role' => User::ROLE_ADMIN])->save();

        $this->newLine();
        $this->info($existed ? 'Existing account promoted to administrator.' : 'Administrator created.');
        $this->line("  Email:    {$email}");

        if (! $this->option('password')) {
            $this->line("  Password: {$password}");
            $this->warn('  Store this password now — it is not shown again.');
        }

        $this->newLine();
        $this->line('  Sign in at /admin/login');

        return self::SUCCESS;
    }
}
