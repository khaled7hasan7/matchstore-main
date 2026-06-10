<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Presets
    |--------------------------------------------------------------------------
    |
    | Pre-designed color schemes for the store frontend. Each preset includes
    | all necessary colors for a complete theme.
    |
    */
    'presets' => [
        'default' => [
            'name' => 'Classic Black',
            'name_key' => 'cms.site_settings.theme_classic_black',
            'primary' => '#000000',
            'primary_light' => '#777777',
            'secondary' => '#333333',
            'background' => '#ffffff',
            'card_bg' => '#f5f5f5',
            'text' => '#111111',
            'border' => '#bbbbbb',
        ],
        'purple' => [
            'name' => 'Purple Elegance',
            'name_key' => 'cms.site_settings.theme_purple_elegance',
            'primary' => '#805c98',
            'primary_light' => '#a06cd5',
            'secondary' => '#6d3faa',
            'background' => '#ffffff',
            'card_bg' => '#f3f0f7',
            'text' => '#2c1e3f',
            'border' => '#d4c5e0',
        ],
        'ocean' => [
            'name' => 'Ocean Blue',
            'name_key' => 'cms.site_settings.theme_ocean_blue',
            'primary' => '#0077be',
            'primary_light' => '#4da6d9',
            'secondary' => '#005a8f',
            'background' => '#ffffff',
            'card_bg' => '#f0f8ff',
            'text' => '#1a2633',
            'border' => '#b8d4e8',
        ],
        'forest' => [
            'name' => 'Forest Green',
            'name_key' => 'cms.site_settings.theme_forest_green',
            'primary' => '#2d5016',
            'primary_light' => '#5a8c3a',
            'secondary' => '#1e3810',
            'background' => '#ffffff',
            'card_bg' => '#f4f7f2',
            'text' => '#1c2817',
            'border' => '#c4d5bd',
        ],
        'sunset' => [
            'name' => 'Sunset Orange',
            'name_key' => 'cms.site_settings.theme_sunset_orange',
            'primary' => '#ff6b35',
            'primary_light' => '#ff9671',
            'secondary' => '#c44d2c',
            'background' => '#ffffff',
            'card_bg' => '#fff5f2',
            'text' => '#2b1d1a',
            'border' => '#f0d4c8',
        ],
        'teal' => [
            'name' => 'Modern Teal',
            'name_key' => 'cms.site_settings.theme_modern_teal',
            'primary' => '#00a8a8',
            'primary_light' => '#5cc5c5',
            'secondary' => '#007a7a',
            'background' => '#ffffff',
            'card_bg' => '#f0fafa',
            'text' => '#1a3333',
            'border' => '#b8e0e0',
        ],
        'matchsystems' => [
            'name' => 'Match Systems',
            'name_key' => 'cms.site_settings.theme_match_systems',
            'primary' => '#0096D6',        // Bright blue from logo
            'primary_light' => '#7CB342',  // Bright green for hovers/accents
            'secondary' => '#2d5a7b',      // Deep blue-gray
            'background' => '#ffffff',
            'card_bg' => '#f8fdf9',        // Very light green tint
            'text' => '#1a1a1a',
            'border' => '#c5e1a5',         // Light green border
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Variable Mapping
    |--------------------------------------------------------------------------
    |
    | Maps theme color keys to CSS variables used in the Xylo theme.
    | This allows dynamic theme switching without modifying CSS files.
    |
    */
    'css_variable_mapping' => [
        'primary' => '--main-color',
        'primary_light' => '--main-color-light',
        'secondary' => '--grid-color-1',
        'background' => '--white',
        'card_bg' => '--cardbg',
        'text' => '--dark-color',
        'border' => '--grid-color-2',
    ],
];
