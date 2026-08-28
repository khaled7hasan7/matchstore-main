<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StoreMenuComposer
{
    /**
     * The composer runs once per rendered view (layout, partials, components),
     * so the menu is loaded lazily and memoised for the rest of the request.
     * Bound as a singleton in ViewComposerServiceProvider.
     */
    private bool $loaded = false;

    private ?Menu $headerMenu = null;

    public function compose(View $view)
    {
        if (! $this->loaded) {
            $this->loaded = true;
            $this->headerMenu = $this->loadHeaderMenu();
        }

        $view->with('headerMenu', $this->headerMenu);
    }

    private function loadHeaderMenu(): ?Menu
    {
        if (! Schema::hasTable('menus')) {
            return null;
        }

        $locale = app()->getLocale();

        return Menu::where('status', 1)
            ->with([
                'menuItems' => function ($query) use ($locale) {
                    $query->orderBy('order_number', 'asc')
                        ->with(['translation' => function ($query) use ($locale) {
                            $query->where('language_code', $locale);
                        }]);
                },
            ])
            ->first();
    }
}
