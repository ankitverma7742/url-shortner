<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

class RedirectController extends Controller
{
    public function show(string $code)
    {
        $url = ShortUrl::where('short_code', $code)->firstOrFail();

        $url->increment('hits');

        return redirect()->away($url->original_url);
    }
}