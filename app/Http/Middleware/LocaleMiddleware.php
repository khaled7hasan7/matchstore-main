<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Models\SiteSetting;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get site settings once. This middleware runs on every web request,
        // so a database failure must degrade to the built-in defaults instead
        // of taking the whole site down.
        try {
            $siteSettings = Cache::remember('site_settings', 3600, function () {
                return SiteSetting::first();
            });
        } catch (\Throwable $e) {
            $siteSettings = null;
        }

        // If locale is already set in session, use it
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        } else {
            // Get default language from site settings for first-time visitors
            $defaultLanguage = $siteSettings && $siteSettings->default_language
                ? $siteSettings->default_language
                : 'en';
            session(['locale' => $defaultLanguage]);
            App::setLocale($defaultLanguage);
        }

        // If currency is not set in session, set the default currency
        if (!session()->has('currency')) {
            $defaultCurrency = $siteSettings && $siteSettings->default_currency
                ? $siteSettings->default_currency
                : 'USD';
            session(['currency' => $defaultCurrency]);
        }

        return $next($request);
    }
}
