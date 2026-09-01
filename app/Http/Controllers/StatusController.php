<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * What the deployed site is actually running and talking to.
 *
 * Exists because "my changes are not showing" has three very different
 * causes that look identical from the outside: the host never deployed the
 * new commit, the database was never migrated or seeded, or the images are
 * being served from somewhere else. This answers all three in one request.
 *
 * Only facts a visitor could already see are public. Connection coordinates
 * are shown when STATUS_TOKEN is set and matches ?token=.
 */
class StatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $status = [
            'app' => [
                'name' => config('app.name'),
                'environment' => app()->environment(),
                // Vercel injects the commit it built. If this is not the
                // commit you pushed, the host has not deployed it.
                'commit' => substr((string) env('VERCEL_GIT_COMMIT_SHA', ''), 0, 7) ?: null,
                'branch' => env('VERCEL_GIT_COMMIT_REF') ?: null,
                'deployed_at' => env('VERCEL_DEPLOYMENT_ID') ? true : null,
            ],
            'database' => $this->database(),
            'uploads' => config('filesystems.disks.public.driver'),
        ];

        if ($this->tokenMatches()) {
            $status['database']['host'] = config('database.connections.'.config('database.default').'.host');
            $status['database']['name'] = config('database.connections.'.config('database.default').'.database');
        }

        return response()->json($status, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /** @return array<string,mixed> */
    private function database(): array
    {
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            return [
                'driver' => config('database.default'),
                'connected' => false,
                // Enough to tell a wrong password from an unreachable host,
                // without repeating the credentials back.
                'error' => class_basename($e).': '.\Illuminate\Support\Str::limit($e->getMessage(), 160),
            ];
        }

        $counts = [];

        foreach (['products', 'product_variants', 'categories', 'coupons', 'pages', 'orders', 'users'] as $table) {
            try {
                $counts[$table] = DB::table($table)->count();
            } catch (\Throwable $e) {
                $counts[$table] = null;
            }
        }

        try {
            $siteName = DB::table('site_settings')->value('site_name');
            $sampleImage = DB::table('product_images')->value('image_url');
        } catch (\Throwable $e) {
            $siteName = $sampleImage = null;
        }

        return [
            'driver' => DB::connection()->getDriverName(),
            'connected' => true,
            'site_name' => $siteName,
            'counts' => $counts,
            // Where the catalogue points for its pictures: /images/... is the
            // copy shipped with the code, anything else is a bucket.
            'first_product_image' => $sampleImage,
        ];
    }

    private function tokenMatches(): bool
    {
        $expected = (string) env('STATUS_TOKEN', '');

        return $expected !== '' && hash_equals($expected, (string) request()->query('token', ''));
    }
}
