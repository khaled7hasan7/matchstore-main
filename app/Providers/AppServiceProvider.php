<?php

namespace App\Providers;

use App\Repositories\Admin\Attribute\AttributeRepository;
use App\Repositories\Admin\Attribute\AttributeRepositoryInterface;
use App\Repositories\Admin\Banner\BannerRepository;
use App\Repositories\Admin\Banner\BannerRepositoryInterface;
use App\Repositories\Admin\Brand\BrandRepository;
use App\Repositories\Admin\Brand\BrandRepositoryInterface;
use App\Repositories\Admin\Menu\MenuRepository;
use App\Repositories\Admin\Menu\MenuRepositoryInterface;
use App\Repositories\Admin\MenuItem\MenuItemRepository;
use App\Repositories\Admin\MenuItem\MenuItemRepositoryInterface;
use App\Repositories\Admin\Product\ProductRepository;
use App\Repositories\Admin\Product\ProductRepositoryInterface;
use App\Repositories\Admin\SocialMediaLink\SocialMediaLinkRepository;
use App\Repositories\Admin\SocialMediaLink\SocialMediaLinkRepositoryInterface;
use App\Services\Admin\ImageService;
use App\Services\Admin\MenuService;
use App\Filesystem\SupabaseStorageAdapter;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Filesystem\FilesystemAdapter as LaravelFilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem as Flysystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Admin\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Admin\Category\CategoryRepository::class
        );

        $this->app->singleton(ImageService::class, function ($app) {
            return new ImageService;
        });

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);

        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);

        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(MenuService::class, MenuService::class);

        $this->app->bind(SocialMediaLinkRepositoryInterface::class, SocialMediaLinkRepository::class);

        $this->app->bind(MenuItemRepositoryInterface::class, MenuItemRepository::class);

        $this->app->bind(AttributeRepositoryInterface::class, AttributeRepository::class);
    }

    /**
     * Supabase Storage as a filesystem disk.
     *
     * Registered as a driver rather than reusing the s3 one so the AWS SDK
     * stays out of the dependency list — see SupabaseStorageAdapter.
     */
    private function registerSupabaseDisk(): void
    {
        Storage::extend('supabase', function ($app, array $config) {
            $adapter = new SupabaseStorageAdapter(
                (string) ($config['bucket'] ?? ''),
                (string) ($config['key'] ?? ''),
                rtrim((string) ($config['endpoint'] ?? ''), '/'),
            );

            return new class(new Flysystem($adapter), $adapter, $config) extends LaravelFilesystemAdapter
            {
                public function __construct(Flysystem $driver, private SupabaseStorageAdapter $supabase, array $config)
                {
                    parent::__construct($driver, $supabase, $config);
                }

                public function url($path): string
                {
                    return $this->supabase->publicUrl($path);
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerSupabaseDisk();

        // Case-insensitive LIKE that is portable across drivers: PostgreSQL's
        // LIKE is case-sensitive (unlike MySQL/SQLite), so use ILIKE there.
        QueryBuilder::macro('whereLike', function (string $column, string $value) {
            /** @var QueryBuilder $this */
            $operator = $this->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

            return $this->where($column, $operator, $value);
        });

        QueryBuilder::macro('orWhereLike', function (string $column, string $value) {
            /** @var QueryBuilder $this */
            $operator = $this->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

            return $this->orWhere($column, $operator, $value);
        });

        // Share site settings with all views. This runs for every view —
        // including the error pages — so a database failure here must never
        // throw, or Laravel's error page cannot render and the visitor gets
        // a bare server error instead of the real message.
        View::composer('*', function ($view) {
            try {
                $siteSettings = Cache::remember('site_settings', 3600, function () {
                    return SiteSetting::first();
                });
            } catch (\Throwable $e) {
                $siteSettings = null;
            }

            // Make site settings available as 'siteSettings' in all views
            $view->with('siteSettings', $siteSettings);
        });
    }
}
