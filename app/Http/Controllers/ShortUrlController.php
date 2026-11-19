<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    public function create()
    {
        return view('urls.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
        ]);

        $user = $request->user();

        $user->shortUrls()->create([
            'company_id' => $user->company_id,
            'original_url' => $data['original_url'],
            'short_code' => $this->generateCode(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Short URL generated');
    }

    private function generateCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}