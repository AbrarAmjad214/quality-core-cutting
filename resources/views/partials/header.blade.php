@php
    // @section('x', 'text') values arrive HTML-escaped; decode once so {{ }} below escapes exactly once.
    $section = fn ($name) => html_entity_decode(trim($__env->yieldContent($name)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $title = $section('title') ?: config('site.name') . ' | ' . config('site.tagline');
    $description = $section('description') ?: config('site.description');
    $ogImage = $section('og_image') ?: asset(config('site.og_image'));
    $robots = $section('robots') ?: 'index, follow, max-image-preview:large';
    $services = \App\Support\Content::services();
@endphp
<!DOCTYPE html>
<html lang="en-AE">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @if (config('site.google_verification'))<meta name="google-site-verification" content="{{ config('site.google_verification') }}">@endif
    @if (config('site.bing_verification'))<meta name="msvalidate.01" content="{{ config('site.bing_verification') }}">@endif
    <meta name="geo.region" content="AE-AZ">
    <meta name="geo.placename" content="Abu Dhabi">

    {{-- Open Graph / social --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_AE">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $title }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Icons --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon-180.png') }}">
    <meta name="theme-color" content="#0A0D12">

    {{-- Fonts (self-hosted) + styles --}}
    <link rel="preload" href="{{ asset('assets/fonts/archivo-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset_v('assets/css/app.css') }}">
    @stack('styles')

    {{-- Structured data (JSON-LD) --}}
    @include('partials.schema.organization')
    @include('partials.schema.website')
    @include('partials.schema.webpage', ['title' => $title, 'description' => $description])
    @stack('schema')
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<div class="topbar">
    <div class="container topbar__inner">
        <p class="topbar__areas"><span class="pill__dot"></span> Available 24/7 · Abu Dhabi · Dubai · Sharjah · All 7 Emirates</p>
        <ul class="topbar__links">
            <li><a href="mailto:{{ config('site.email') }}"><x-icon name="mail" size="16" /> {{ config('site.email') }}</a></li>
            <li><a href="{{ tel_link() }}"><x-icon name="phone" size="16" /> {{ config('site.phone') }}</a></li>
        </ul>
    </div>
</div>

<header class="site-header" data-header>
    <div class="container site-header__inner">
        <a href="{{ route('home') }}" class="logo" aria-label="{{ config('site.name') }} — home">
            <img src="{{ asset(config('site.logo')) }}" alt="{{ config('site.name') }}" width="548" height="263">
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <x-icon name="menu" class="nav-toggle__open" /><x-icon name="close" class="nav-toggle__close" />
            <span class="sr-only">Menu</span>
        </button>

        <nav class="site-nav" id="site-nav" aria-label="Main" data-nav>
            <ul class="site-nav__list">
                <li><a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a></li>
                <li><a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About Us</a></li>
                <li class="has-sub">
                    <a href="{{ route('services') }}" @if (request()->routeIs('services', 'service.show')) aria-current="page" @endif>Services</a>
                    <button class="sub-toggle" type="button" aria-expanded="false" data-sub-toggle>
                        <x-icon name="chevron" size="18" /><span class="sr-only">Show services</span>
                    </button>
                    <ul class="sub-menu">
                        @foreach ($services as $s)
                            <li>
                                <a href="{{ route('service.show', $s['slug']) }}" @if (request()->route('slug') === $s['slug']) aria-current="page" @endif>{{ $s['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('projects') }}" @if (request()->routeIs('projects')) aria-current="page" @endif>Projects</a></li>
                <li><a href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif>Contact</a></li>
            </ul>
            <a href="{{ route('contact') }}#quote" class="btn btn--primary btn--sm site-nav__cta">Get a quote</a>
        </nav>
    </div>
</header>
