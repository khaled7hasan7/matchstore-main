<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Store Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains store-specific customization settings that allow
    | different stores to have their own branding, colors, and behavior.
    |
    */

    'name' => env('STORE_NAME', 'MatchStore'),

    /*
    |--------------------------------------------------------------------------
    | Brand Colors
    |--------------------------------------------------------------------------
    |
    | Customize the color scheme for the store. These colors will be used
    | throughout the frontend theme.
    |
    */

    'primary_color' => env('STORE_PRIMARY_COLOR', '#0e0e0e'),
    'secondary_color' => env('STORE_SECONDARY_COLOR', '#f8f9fa'),
    'accent_color' => env('STORE_ACCENT_COLOR', '#ffc107'),

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    */

    'default_currency' => env('STORE_DEFAULT_CURRENCY', 'USD'),

    /*
    |--------------------------------------------------------------------------
    | Checkout Settings
    |--------------------------------------------------------------------------
    */

    'allow_guest_checkout' => env('STORE_GUEST_CHECKOUT', true),
    'require_shipping_address' => env('STORE_REQUIRE_SHIPPING', true),

    /*
    |--------------------------------------------------------------------------
    | Product Settings
    |--------------------------------------------------------------------------
    */

    'products_per_page' => env('STORE_PRODUCTS_PER_PAGE', 12),
    'enable_reviews' => env('STORE_ENABLE_REVIEWS', true),
    'enable_wishlist' => env('STORE_ENABLE_WISHLIST', true),

    /*
    |--------------------------------------------------------------------------
    | SEO Settings
    |--------------------------------------------------------------------------
    */

    'default_meta_description' => env('STORE_META_DESCRIPTION', 'Your one-stop shop for quality products'),
    'default_meta_keywords' => env('STORE_META_KEYWORDS', 'ecommerce, online shopping, products'),

];
