<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(string $slug): View
    {
        $service = Content::service($slug);
        abort_unless($service, 404);

        return view('services.show', [
            'service' => $service,
            'services' => Content::services(),
            'related' => Content::related($slug),
            'company' => Content::company(),
        ]);
    }
}
