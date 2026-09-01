<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        try {
            if (! $this->option('skip-migrate') && $this->call('migrate', ['--force' => true]) !== self::SUCCESS) {
                return $this->failed('فشل تنفيذ الترحيلات.');
            }

            if ($this->call('db:seed', ['--force' => true]) !== self::SUCCESS) {
                return $this->failed('فشل زرع البيانات.');
            }

            if ($email = $this->option('admin')) {
                $this->newLine();
                $this->call('admin:create', array_filter([
                    'email' => $email,
                    '--password' => $this->option('password'),
                ]));
            }
        } catch (\Throwable $e) {
            // Nearly always the database being unreachable. The stack trace
            // says nothing useful in a build log; the message does.
            return $this->failed(class_basename($e).': '.Str::limit($e->getMessage(), 300));
        }

        $this->report();

        return self::SUCCESS;
    }

    /**
     * A failure a build log will actually show, rather than a stack trace
     * scrolled off the top.
     */
    private function failed(string $reason): int
    {
        $this->newLine();
        $this->error('  ✗ '.$reason);
        $this->line('    القاعدة أعلاه هي التي حاول الأمر الوصول إليها.');
        $this->line('    تحقّق أن DB_PASSWORD مضبوط لهذه البيئة وأن الحاوية تقبل الاتصال.');
        $this->newLine();

        return self::FAILURE;
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
        $rows[] = ['قرص الرفع', config('filesystems.disks.public.driver') === 'supabase'
            ? 'Supabase Storage'
            : 'محلي — الرفع من لوحة الأدمن لن ينجح على Vercel'];

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
