<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * One command to bring a database up to date and report what is in it.
 *
 * Exists because "the site has not changed" almost always means one of two
 * things: the seeders were never run against the database the site reads, or
 * they were run against a different one. Both are visible the moment you can
 * see the connection and the row counts side by side.
 */
class FalakSetup extends Command
{
    protected $signature = 'falak:setup
                            {--check : Only report what is in the database, change nothing}
                            {--admin= : Email address for the administrator account}
                            {--password= : Use this password for the administrator instead of generating one}
                            {--skip-migrate : Do not run migrations}';

    protected $description = 'Migrate, seed and report the state of the store, and optionally create the administrator.';

    public function handle(): int
    {
        $this->showConnection();

        if ($this->option('check')) {
            $this->report();

            return self::SUCCESS;
        }

        if (! $this->option('skip-migrate')) {
            $this->call('migrate', ['--force' => true]);
        }

        $this->call('db:seed', ['--force' => true]);

        if ($email = $this->option('admin')) {
            $this->newLine();
            $this->call('admin:create', array_filter([
                'email' => $email,
                '--password' => $this->option('password'),
            ]));
        }

        $this->report();

        return self::SUCCESS;
    }

    private function showConnection(): void
    {
        $connection = DB::connection();
        $config = $connection->getConfig();

        $this->newLine();
        $this->line('  <options=bold>قاعدة البيانات التي سيعمل عليها هذا الأمر</>');
        $this->table([], [
            ['المحرّك', $connection->getDriverName()],
            ['المضيف', $config['host'] ?? '—'],
            ['القاعدة', $config['database'] ?? '—'],
            ['المستخدم', $config['username'] ?? '—'],
        ]);

        if (! str_contains((string) ($config['host'] ?? ''), 'supabase')) {
            $this->warn('  هذه ليست قاعدة Supabase — الموقع المنشور لن يرى هذه التغييرات.');
            $this->newLine();
        }
    }

    private function report(): void
    {
        $rows = [];

        foreach ([
            'المنتجات' => 'products',
            'المتغيّرات (لون × مقاس)' => 'product_variants',
            'الصور' => 'product_images',
            'الأقسام' => 'categories',
            'الماركات' => 'brands',
            'البانرات' => 'banners',
            'البطاقات الترويجية' => 'promo_cards',
            'مناطق الشحن' => 'shipping_regions',
            'الطلبات' => 'orders',
            'المدراء' => 'users',
        ] as $label => $table) {
            $rows[] = [$label, DB::table($table)->count()];
        }

        $rows[] = ['اسم المتجر', DB::table('site_settings')->value('site_name') ?: '—'];

        $this->newLine();
        $this->line('  <options=bold>الحالة الآن</>');
        $this->table([], $rows);

        $catalog = require database_path('data/falak-catalog.php');
        $expected = count($catalog['products']);

        if (DB::table('products')->count() !== $expected) {
            $this->warn("  عدد المنتجات لا يطابق الكتالوج ({$expected}) — شغّل الأمر بدون --check.");
        }
    }
}
