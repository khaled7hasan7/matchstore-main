<?php

namespace Tests\Feature;

use App\Support\HtmlSanitizer;
use Tests\TestCase;

/**
 * Guards the settings a read-only host (Vercel/Lambda) depends on.
 */
class ServerlessReadinessTest extends TestCase
{
    public function test_compiled_view_path_honours_the_environment(): void
    {
        putenv('VIEW_COMPILED_PATH=/tmp/views-under-test');
        $_ENV['VIEW_COMPILED_PATH'] = '/tmp/views-under-test';
        $_SERVER['VIEW_COMPILED_PATH'] = '/tmp/views-under-test';

        try {
            $config = require base_path('config/view.php');

            $this->assertSame(
                '/tmp/views-under-test',
                $config['compiled'],
                'Blade must be able to compile to a writable directory on read-only hosts'
            );
        } finally {
            putenv('VIEW_COMPILED_PATH');
            unset($_ENV['VIEW_COMPILED_PATH'], $_SERVER['VIEW_COMPILED_PATH']);
        }
    }

    public function test_compiled_view_path_never_falls_back_to_false(): void
    {
        $config = require base_path('config/view.php');

        $this->assertIsString($config['compiled']);
        $this->assertNotSame('', $config['compiled']);
    }

    public function test_theme_views_are_resolved_before_shared_views(): void
    {
        $config = require base_path('config/view.php');

        $this->assertStringContainsString('themes', $config['paths'][0]);
    }

    public function test_sanitizer_still_strips_scripts_without_a_cache_directory(): void
    {
        $clean = HtmlSanitizer::clean('<p>وصف <strong>سليم</strong></p><script>alert(1)</script><a href="javascript:x()">z</a>');

        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringContainsString('<strong>سليم</strong>', $clean);
    }

    public function test_both_entry_points_apply_the_deployment_environment(): void
    {
        // artisan did not, so `php artisan migrate` during a deployment build
        // fell back to MySQL on localhost, failed, and left the database
        // untouched while the deploy reported success.
        foreach (['artisan', 'api/index.php'] as $entryPoint) {
            $this->assertStringContainsString(
                'apply-deployment-env.php',
                file_get_contents(base_path($entryPoint)),
                $entryPoint.' must apply the deployment environment before booting'
            );
        }
    }

    public function test_the_deployment_environment_names_a_database_but_no_secret(): void
    {
        $env = require base_path('bootstrap/deployment-env.php');

        $this->assertSame('pgsql', $env['DB_CONNECTION']);
        $this->assertArrayHasKey('DB_HOST', $env);
        $this->assertArrayHasKey('DB_USERNAME', $env);
        $this->assertArrayNotHasKey('DB_PASSWORD', $env, 'the password belongs to the host, not the repository');
    }

    public function test_a_local_env_file_overrides_the_deployment_defaults(): void
    {
        $source = file_get_contents(base_path('bootstrap/apply-deployment-env.php'));

        // Without this guard the deployment's database would be forced on
        // every developer machine, ignoring their own .env.
        $this->assertStringContainsString("file_exists(__DIR__.'/../.env')", $source);
    }
}
