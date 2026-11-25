<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function show(string $city): View
    {
        $location = Content::location($city);
        abort_unless($location, 404);

        return view('locations.show', [
            'location' => $location,
            'services' => Content::services(),
            'company' => Content::company(),
            'others' => array_filter(Content::locations(), fn ($l) => $l['slug'] !== $location['slug']),
        ]);
    }
}
