{{--
    City landing page (local SEO). Content: resources/data/locations.php
--}}
@extends('layouts.app')

@section('title', $location['title'])
@section('description', $location['description'])
@section('og_image', asset("assets/images/{$location['image']}-" . end(\App\Support\Content::image($location['image'])['sizes']) . '.webp'))

@php
    $crumbs = [['Home', route('home')], ['Core cutting ' . $location['city'], null]];
    $cityKey = array_search($location, \App\Support\Content::locations(), true);
@endphp

@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
    @include('partials.schema.location', ['location' => $location])
@endpush

@section('content')

<x-page-hero :eyebrow="'Serving all of ' . $location['city'] . ' · 24/7'" :title="e($location['h1'])" :lead="$location['lead']" :image="$location['image']" :crumbs="$crumbs">
    <a href="#quote" class="btn btn--primary">Get a free quote <x-icon name="arrow" size="18" /></a>
    <a href="{{ tel_link() }}" class="btn btn--glass"><x-icon name="phone" size="18" /> {{ config('site.phone') }}</a>
</x-page-hero>

{{-- Intro --}}
<section class="section">
    <div class="container article">
        <div class="article__main">
            <x-section-head :eyebrow="'Core cutting ' . $location['city']" :title="'Your concrete cutting team in ' . e($location['city'])" />
            <p class="lead" data-reveal="up">{{ $location['intro'][0] }}</p>
            @foreach (array_slice($location['intro'], 1) as $p)
                <p data-reveal="up">{{ $p }}</p>
            @endforeach
        </div>
        <aside class="article__aside">
            <div class="panel panel--dark" data-reveal="card">
                <h3>Areas we cover in {{ $location['city'] }}</h3>
                <ul class="area-tags">
                    @foreach ($location['areas'] as $area)
                        <li>{{ $area }}</li>
                    @endforeach
                </ul>
                <p class="fast-track"><span>Call 24/7</span><a href="{{ tel_link() }}">{{ config('site.phone') }}</a></p>
            </div>
        </aside>
    </div>
</section>

{{-- Typical work --}}
<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Typical jobs" :title="'Concrete cutting work we do in ' . e($location['city'])" />
        <div class="feature-grid feature-grid--2">
            @foreach ($location['work'] as [$title, $text])
                <article class="feature" data-tilt="4">
                    <span class="feature__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="feature__title">{{ $title }}</h3>
                    <p>{{ $text }}</p>
                    <span class="spotlight" aria-hidden="true"></span>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Services --}}
<section class="section section--dark">
    <div class="container">
        <x-section-head eyebrow="Services" :title="'Our services in ' . e($location['city'])"
            :intro="'Every service below is available across ' . $location['city'] . ', with GPR concrete scanning before any cutting or drilling.'" />
        <div class="bento" data-stagger="card">
            @foreach (array_values($services) as $i => $s)
                <x-service-card :service="$s" :size="$i < 2 ? 'lg' : null" />
            @endforeach
        </div>
    </div>
</section>

<x-process-scroll :steps="$company['process']" :title="'How a ' . e($location['city']) . ' job runs'"
    intro="Scan, plan, cut clean, hand over — the same four steps on every job."
    :images="['gpr-floor-scanning', 'concrete-scanning-tablet', 'core-drilling-floor', 'core-cutting-pipe-opening']" />

{{-- Local working --}}
<section class="section">
    <div class="container split split--center">
        <x-section-head eyebrow="Working on site" :title="'Site rules, safety &amp; paperwork in ' . e($location['city'])" :intro="$location['local']" />
        <div class="panel" data-reveal="card">
            <x-check-list :items="$company['compliance']['points']" data-stagger="up" />
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="section section--soft">
    <div class="container faq-layout">
        <div class="faq-layout__aside">
            <x-section-head eyebrow="FAQ" :title="'Core cutting in ' . e($location['city']) . ': common questions'" />
            <p class="section-intro" data-reveal="up">Also working in
                @foreach ($others as $o)
                    <a href="{{ route('location.show', array_search($o, \App\Support\Content::locations(), true)) }}">{{ $o['city'] }}</a>@if (! $loop->last) and @endif
                @endforeach
                — and across all seven Emirates.</p>
        </div>
        <x-faq :faqs="$location['faqs']" />
    </div>
</section>

<x-quote-section :title="'Get a free quote in <span class=\'accent\'>' . e($location['city']) . '</span>'" />

@endsection
