<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'services' => Content::services(),
            'company' => Content::company(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'services' => Content::services(),
            'company' => Content::company(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'services' => Content::services(),
            'company' => Content::company(),
        ]);
    }

    public function projects(): View
    {
        return view('pages.projects', [
            'services' => Content::services(),
            'company' => Content::company(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'services' => Content::services(),
        ]);
    }
}
