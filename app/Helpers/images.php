<?php

if (! function_exists('store_image')) {
    /**
     * Resolve a stored image reference to a URL the browser can load.
     *
     * Values reach us in four shapes: an absolute URL (seeded catalogue and
     * remote CDNs), a root-relative path (assets shipped in public/), a plain
     * storage path from an admin upload, and the legacy "public/…" prefix that
     * older uploads were saved with.
     */
    function store_image(?string $path, string $fallback = 'default.jpg'): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            $path = $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            // Shipped with the application (public/). asset() rather than the
            // bare path so the URL is absolute — emails need that.
            return asset($path);
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }

        // An upload: ask the disk where it lives, since that is the local
        // filesystem in development and Supabase Storage on the host.
        try {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
        } catch (\Throwable $e) {
            return asset('storage/'.$path);
        }
    }
}
