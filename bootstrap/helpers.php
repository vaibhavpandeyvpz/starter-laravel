<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('cdn_url')) {
    function cdn_url(string $path, string $disk = 's3'): string
    {
        if ($cdn = config('app.cdn_url')) {
            return rtrim($cdn, '/').'/'.ltrim($path, '/');
        }

        if ($disk === 'public') {
            return Storage::disk($disk)->url($path);
        }

        return Storage::disk($disk)->temporaryUrl($path, now()->addWeek());
    }
}
