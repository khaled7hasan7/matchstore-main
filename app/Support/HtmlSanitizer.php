<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * Sanitizes vendor-supplied rich text (CKEditor output) before it is
 * rendered unescaped in Blade views. Strips scripts, event handlers and
 * javascript: URLs while keeping normal formatting markup.
 */
class HtmlSanitizer
{
    protected static ?HTMLPurifier $purifier = null;

    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        return static::purifier()->purify($html);
    }

    protected static function purifier(): HTMLPurifier
    {
        if (static::$purifier === null) {
            $config = HTMLPurifier_Config::createDefault();
            $config->set('HTML.Allowed', implode(',', [
                'p', 'br', 'hr', 'b', 'strong', 'i', 'em', 'u', 's',
                'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'blockquote', 'pre', 'code', 'span[style]', 'div',
                'a[href|title|rel]', 'img[src|alt|width|height]',
                'table', 'thead', 'tbody', 'tr', 'th', 'td',
            ]));
            $config->set('CSS.AllowedProperties', 'color,text-align,font-weight,font-style,text-decoration');
            $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
            $config->set('HTML.Nofollow', true);
            if ($cachePath = static::writableCachePath()) {
                $config->set('Cache.SerializerPath', $cachePath);
            } else {
                // Nowhere writable (read-only serverless host): run without a
                // definition cache rather than failing to sanitize at all.
                $config->set('Cache.DefinitionImpl', null);
            }

            static::$purifier = new HTMLPurifier($config);
        }

        return static::$purifier;
    }

    /**
     * First writable directory for HTMLPurifier's definition cache, or null
     * when the host allows no writes at all.
     */
    protected static function writableCachePath(): ?string
    {
        foreach ([storage_path('app/purifier'), sys_get_temp_dir().'/htmlpurifier'] as $path) {
            if (! is_dir($path)) {
                @mkdir($path, 0755, true);
            }

            if (is_dir($path) && is_writable($path)) {
                return $path;
            }
        }

        return null;
    }
}
