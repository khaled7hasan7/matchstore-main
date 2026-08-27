<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first();

        return view('admin.site-settings.index', compact('settings'));
    }

    public function edit()
    {
        $settings = SiteSetting::firstOrNew();
        $currencies = \App\Models\Currency::all();
        $languages = [
            'en' => 'English',
            'ar' => 'العربية (Arabic)',
        ];

        return view('admin.site-settings.edit', compact('settings', 'currencies', 'languages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:1024',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'contact_phone_2' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'default_currency' => 'nullable|string|exists:currencies,code',
            'default_language' => 'nullable|string|in:en,ar',
        ]);

        // Get or create settings record
        $settings = SiteSetting::firstOrNew();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }

            // Store new logo
            $logoPath = $request->file('logo')->store('site-assets', 'public');
            $settings->logo = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }

            // Store new favicon
            $faviconPath = $request->file('favicon')->store('site-assets', 'public');
            $settings->favicon = $faviconPath;
        }

        // Update other fields (convert string "null" to actual null)
        $settings->site_name = $request->site_name;
        $settings->tagline = $request->tagline === 'null' ? null : $request->tagline;
        $settings->meta_title = $request->meta_title === 'null' ? null : $request->meta_title;
        $settings->meta_description = $request->meta_description === 'null' ? null : $request->meta_description;
        $settings->meta_keywords = $request->meta_keywords === 'null' ? null : $request->meta_keywords;
        $settings->contact_email = $request->contact_email === 'null' ? null : $request->contact_email;
        $settings->contact_phone = $request->contact_phone === 'null' ? null : $request->contact_phone;
        $settings->contact_phone_2 = $request->contact_phone_2 === 'null' ? null : $request->contact_phone_2;
        $settings->address = $request->address === 'null' ? null : $request->address;
        $settings->footer_text = $request->footer_text === 'null' ? null : $request->footer_text;
        $settings->default_currency = $request->default_currency ?? 'USD';
        $settings->default_language = $request->default_language ?? 'en';

        $settings->save();

        // Clear the site settings cache so new defaults take effect immediately
        Cache::forget('site_settings');

        return redirect()->back()->with('success', 'Site settings updated successfully!');
    }

    public function updateTheme(Request $request)
    {
        // DEBUG: Log incoming request data
        \Log::info('=== THEME UPDATE DEBUG ===');
        \Log::info('All Request Data:', $request->all());
        \Log::info('Has theme_custom_enabled:', [
            'has' => $request->has('theme_custom_enabled'),
            'value' => $request->theme_custom_enabled,
            'input' => $request->input('theme_custom_enabled')
        ]);

        $request->validate([
            'theme_preset' => 'required|string|in:' . implode(',', array_keys(config('theme.presets'))),
            'theme_custom_enabled' => 'nullable|in:1',
            'theme_primary_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_primary_light_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_secondary_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_card_background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_text_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'theme_border_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        // Save preset selection
        $presetSaved = StoreSetting::updateOrCreate(
            ['key' => 'theme_preset'],
            ['value' => $request->theme_preset]
        );
        \Log::info('Preset saved:', ['preset' => $request->theme_preset, 'saved' => $presetSaved->wasRecentlyCreated]);

        // Save custom enabled flag (checkbox: 1 if checked, null if unchecked)
        $customEnabled = $request->has('theme_custom_enabled') && $request->theme_custom_enabled == '1';
        $customSaved = StoreSetting::updateOrCreate(
            ['key' => 'theme_custom_enabled'],
            ['value' => $customEnabled ? '1' : '0']
        );
        \Log::info('Custom enabled saved:', [
            'customEnabled' => $customEnabled,
            'value_saved' => $customEnabled ? '1' : '0',
            'wasNew' => $customSaved->wasRecentlyCreated
        ]);

        // Save custom colors if custom mode is enabled
        if ($customEnabled) {
            \Log::info('Saving custom colors...');
            $customColors = [
                'theme_primary_color',
                'theme_primary_light_color',
                'theme_secondary_color',
                'theme_background_color',
                'theme_card_background_color',
                'theme_text_color',
                'theme_border_color',
            ];

            foreach ($customColors as $colorKey) {
                if ($request->filled($colorKey)) {
                    $saved = StoreSetting::updateOrCreate(
                        ['key' => $colorKey],
                        ['value' => $request->$colorKey]
                    );
                    \Log::info("Saved {$colorKey}:", ['value' => $request->$colorKey]);
                }
            }
        } else {
            \Log::info('Custom colors NOT enabled, skipping color save');
        }

        // Clear theme cache - must clear both the combined cache and individual setting caches
        \Log::info('Clearing all theme caches...');
        Cache::forget('active_theme_colors');
        Cache::forget('store_setting_theme_preset');
        Cache::forget('store_setting_theme_custom_enabled');
        Cache::forget('store_setting_theme_primary_color');
        Cache::forget('store_setting_theme_primary_light_color');
        Cache::forget('store_setting_theme_secondary_color');
        Cache::forget('store_setting_theme_background_color');
        Cache::forget('store_setting_theme_card_background_color');
        Cache::forget('store_setting_theme_text_color');
        Cache::forget('store_setting_theme_border_color');

        // Verify what's in DB after save
        $verifyPreset = StoreSetting::where('key', 'theme_preset')->first();
        $verifyCustom = StoreSetting::where('key', 'theme_custom_enabled')->first();
        \Log::info('Verification after save:', [
            'theme_preset' => $verifyPreset ? $verifyPreset->value : 'NULL',
            'theme_custom_enabled' => $verifyCustom ? $verifyCustom->value : 'NULL'
        ]);

        \Log::info('=== END THEME UPDATE DEBUG ===');

        // Return JSON for AJAX requests, redirect for regular form submissions
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Theme settings updated successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Theme settings updated successfully!');
    }
}
