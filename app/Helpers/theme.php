<?php

use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getActiveThemeColors')) {
    /**
     * Get the currently active theme colors
     *
     * Returns custom colors if custom mode is enabled,
     * otherwise returns the selected preset theme colors.
     * Results are cached forever until settings change.
     *
     * @return array Associative array of color keys and hex values
     */
    function getActiveThemeColors()
    {
        return Cache::rememberForever('active_theme_colors', function () {
            $customEnabled = getWebConfig('theme_custom_enabled', '0') === '1';

            if ($customEnabled) {
                // Return custom colors
                return [
                    'primary' => getWebConfig('theme_primary_color', '#000000'),
                    'primary_light' => getWebConfig('theme_primary_light_color', '#777777'),
                    'secondary' => getWebConfig('theme_secondary_color', '#333333'),
                    'background' => getWebConfig('theme_background_color', '#ffffff'),
                    'card_bg' => getWebConfig('theme_card_background_color', '#f5f5f5'),
                    'text' => getWebConfig('theme_text_color', '#111111'),
                    'border' => getWebConfig('theme_border_color', '#bbbbbb'),
                ];
            }

            // Return preset theme colors
            $presetKey = getWebConfig('theme_preset', 'default');
            $presets = config('theme.presets');

            return $presets[$presetKey] ?? $presets['default'];
        });
    }
}

if (!function_exists('getThemeCssVariables')) {
    /**
     * Get formatted CSS variables string for current theme
     *
     * Returns a string of CSS variable declarations that can be
     * injected into a <style> tag in the document head.
     *
     * @return string CSS variables formatted as: --var-name: #hexcode;
     */
    function getThemeCssVariables()
    {
        $colors = getActiveThemeColors();
        $mapping = config('theme.css_variable_mapping');

        $css = '';
        foreach ($colors as $key => $value) {
            if (isset($mapping[$key])) {
                $css .= "{$mapping[$key]}: {$value} !important; ";
            }
        }

        return trim($css);
    }
}
