<?php

namespace App\View\Composers;

use App\Models\Language;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminLanguageComposer
{
    /**
     * Memoised per request — see StoreMenuComposer. Bound as a singleton in
     * ViewComposerServiceProvider.
     */
    private bool $loaded = false;

    private array $shared = [];

    public function compose(View $view)
    {
        if (! $this->loaded) {
            $this->loaded = true;

            if (Schema::hasTable('menus')) {
                $this->shared['menu'] = Menu::first();
            }
            if (Schema::hasTable('languages')) {
                $this->shared['activeLanguages'] = Language::where('active', 1)->get();
            }
        }

        $view->with($this->shared);
    }
}
