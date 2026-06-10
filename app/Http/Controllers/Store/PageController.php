<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified page by slug.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Find the page by slug with its translation
        $page = Page::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Get the translation for the current locale
        $translation = $page->translations()
            ->where('language_code', app()->getLocale())
            ->first();

        // Fallback to default translation if current locale not found
        if (!$translation) {
            $translation = $page->translations()->first();
        }

        if (!$translation) {
            abort(404, 'Page content not found');
        }

        return view('themes.xylo.page', compact('page', 'translation'));
    }
}
