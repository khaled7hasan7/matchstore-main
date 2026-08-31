<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Puts the shop's images in Supabase Storage.
 *
 * The catalogue artwork already ships in public/ and is served by the host,
 * so this is not needed to make the store work. It matters for what comes
 * next: real product photographs uploaded from the admin panel, which have
 * nowhere to go on a read-only host unless this bucket is configured.
 */
class FalakStorage extends Command
{
    protected $signature = 'falak:storage
                            {--push : Upload the catalogue artwork in public/images/catalog to the bucket}
                            {--rewrite-urls : Point the database at the uploaded copies instead of the shipped ones}';

    protected $description = 'Check the Supabase Storage connection, and optionally upload the catalogue images.';

    public function handle(): int
    {
        $bucket = config('filesystems.disks.supabase.bucket');
        $endpoint = config('filesystems.disks.supabase.endpoint');

        $this->newLine();
        $this->table([], [
            ['الحاوية (bucket)', $bucket ?: '— غير مضبوطة'],
            ['العنوان', $endpoint ?: '— غير مضبوط'],
            ['المفتاح', config('filesystems.disks.supabase.key') ? 'مضبوط' : '— غير مضبوط'],
            ['قرص الرفع الحالي', config('filesystems.disks.public.driver')],
        ]);

        if (! $bucket || ! $endpoint || ! config('filesystems.disks.supabase.key')) {
            $this->error('  إعدادات Supabase Storage ناقصة — راجع SUPABASE_STORAGE_* في .env.example');

            return self::FAILURE;
        }

        if (! $this->verifyConnection()) {
            return self::FAILURE;
        }

        if ($this->option('push')) {
            $uploaded = $this->push();

            if ($this->option('rewrite-urls')) {
                $this->rewriteUrls();
            }

            $this->newLine();
            $this->info("  تم رفع {$uploaded} ملفاً.");
        }

        return self::SUCCESS;
    }

    private function verifyConnection(): bool
    {
        $probe = 'falak-connection-check.txt';

        try {
            Storage::disk('supabase')->put($probe, 'ok');
            $readBack = Storage::disk('supabase')->get($probe);
            Storage::disk('supabase')->delete($probe);
        } catch (\Throwable $e) {
            $this->error('  تعذّر الاتصال بالحاوية: '.$e->getMessage());
            $this->line('  تأكد أن الحاوية موجودة وعامة (public) وأن المفتاح هو service_role.');

            return false;
        }

        if ($readBack !== 'ok') {
            $this->error('  الكتابة نجحت لكن القراءة رجعت محتوى مختلفاً.');

            return false;
        }

        $this->info('  الاتصال بالحاوية سليم (كتابة وقراءة وحذف).');

        return true;
    }

    private function push(): int
    {
        $source = public_path('images/catalog');
        $files = glob($source.'/*.svg') ?: [];
        $disk = Storage::disk('supabase');
        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $file) {
            $disk->put('catalog/'.basename($file), file_get_contents($file));
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        return count($files);
    }

    /**
     * Swap the shipped paths for the uploaded ones, everywhere an image is
     * referenced. Runs only on the paths this application seeded, so a real
     * upload someone made through the admin panel is left alone.
     */
    private function rewriteUrls(): void
    {
        $base = rtrim(Storage::disk('supabase')->url('catalog'), '/');
        $rows = 0;

        foreach ([
            ['product_images', 'image_url'],
            ['category_translations', 'image_url'],
            ['banner_translations', 'image_url'],
            ['promo_card_translations', 'image_url'],
            ['site_settings', 'logo'],
        ] as [$table, $column]) {
            $rows += DB::table($table)
                ->where($column, 'like', '/images/catalog/%')
                ->update([
                    $column => DB::raw("replace({$column}, '/images/catalog', ".DB::getPdo()->quote($base).')'),
                ]);
        }

        $this->line("  حُدِّث {$rows} مسار صورة في قاعدة البيانات.");
    }
}
