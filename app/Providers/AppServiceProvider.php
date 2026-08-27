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
use Illuminate\Database\Query\Builder as QueryBuilder;
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
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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

        // Share site settings with all views
        View::composer('*', function ($view) {
            $siteSettings = Cache::remember('site_settings', 3600, function () {
                return SiteSetting::first();
            });

            // Make site settings available as 'siteSettings' in all views
            $view->with('siteSettings', $siteSettings);
        });
    }
}
