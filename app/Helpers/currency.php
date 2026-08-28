<?php

use App\Models\Currency;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('convert_price')) {
    function convert_price($amount, $currencyCode = null)
    {
        $currencyCode = $currencyCode ?: session('currency', getWebConfig('default_currency', 'USD'));

        $usdExchangeRate = Cache::rememberForever('currency_USD', function () {
            return Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        });

        $targetExchangeRate = Cache::rememberForever("currency_{$currencyCode}", function () use ($currencyCode) {
            return Currency::where('code', $currencyCode)->value('exchange_rate') ?: 1.0;
        });

        return round($amount * ($targetExchangeRate / $usdExchangeRate), 2);
    }
}

if (! function_exists('currency_to_usd')) {
    function currency_to_usd($amount, $fromCurrency)
    {
        $usdRate = Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        $fromRate = Currency::where('code', $fromCurrency)->value('exchange_rate') ?: 1.0;

        return round($amount * ($usdRate / $fromRate), 2);
    }
}

if (! function_exists('getWebConfig')) {
    function getWebConfig($key, $default = null)
    {
        try {
            return Cache::rememberForever("store_setting_{$key}", function () use ($key, $default) {
                return StoreSetting::where('key', $key)->value('value') ?? $default;
            });
        } catch (\Throwable $e) {
            // Store settings are read while rendering every page (theme colors,
            // default currency); fall back rather than fail the request.
            return $default;
        }
    }
}

if (! function_exists('activeCurrency')) {
    /**
     * The active currency, never null.
     *
     * Views read $currency->symbol directly, so returning null on a fresh
     * (unseeded) database or during a database outage would fatal every
     * storefront page. The fallback is deliberately not cached, so the real
     * row is picked up as soon as it exists.
     */
    function activeCurrency(): Currency
    {
        $code = session('currency', 'USD');

        try {
            $currency = Cache::rememberForever('active_currency_'.$code, function () use ($code) {
                return Currency::where('code', $code)->first();
            });
        } catch (\Throwable $e) {
            $currency = null;
        }

        if ($currency) {
            return $currency;
        }

        Cache::forget('active_currency_'.$code);

        $fallback = new Currency;
        $fallback->name = 'US Dollar';
        $fallback->code = 'USD';
        $fallback->symbol = '$';
        $fallback->exchange_rate = 1.0;

        return $fallback;
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol()
    {
        return activeCurrency()->symbol ?: '$';
    }
}
