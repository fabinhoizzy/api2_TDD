<?php

use App\Models\ShortUrl;
use Illuminate\Support\Facades\Route;

Route::get('{shortUrl:code}', function (ShortUrl $shortUrl) {
    $shortUrl->visits()->create([
       'ip_address' => request()->ip(),
       'user_agent' => request()->userAgent(),
    ]);

    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
