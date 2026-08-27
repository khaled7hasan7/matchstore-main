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
            $cachePath = storage_path('app/purifier');

            if (! is_dir($cachePath)) {
                mkdir($cachePath, 0755, true);
            }

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
            $config->set('Cache.SerializerPath', $cachePath);

            static::$purifier = new HTMLPurifier($config);
        }

        return static::$purifier;
    }
}
