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
}
