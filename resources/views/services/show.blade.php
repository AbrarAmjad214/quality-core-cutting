{{--
    One template for every service page. Content: resources/data/services.php
--}}
@extends('layouts.app')

@section('title', $service['title'])
@section('description', $service['description'])
@section('og_image', asset("assets/images/{$service['image']}-" . end(\App\Support\Content::image($service['image'])['sizes']) . '.webp'))

@php
    $crumbs = [['Home', route('home')], ['Services', route('services')], [$service['name'], null]];
    $sectorIcons = ['Residential' => 'home', 'Commercial' => 'building', 'Industrial' => 'factory', 'Infrastructure' => 'road',
                    'Facility' => 'wrench', 'Marine' => 'droplet', 'Demolition' => 'demolition', 'Redevelopment' => 'civil'];
    $sectorIcon = function ($title) use ($sectorIcons) {
        foreach ($sectorIcons as $word => $icon) { if (str_contains($title, $word)) return $icon; }
        return 'building';
    };
    $short = strtolower(str_replace(' (GPR)', '', $service['name']));
@endphp

@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
    @include('partials.schema.service', ['service' => $service])
@endpush

@section('content')

<x-page-hero eyebrow="Abu Dhabi · Dubai · Sharjah · All 7 Emirates" :title="e($service['h1'])" :lead="$service['lead']" :image="$service['image']" :crumbs="$crumbs">
    <a href="#quote" class="btn btn--primary">Get a free quote <x-icon name="arrow" size="18" /></a>
    <a href="{{ tel_link() }}" class="btn btn--glass"><x-icon name="phone" size="18" /> {{ config('site.phone') }}</a>
</x-page-hero>

<x-marquee :items="array_merge([$service['name']], $service['what']['uses'])" />

{{-- What is --}}
<section class="section">
    <div class="container article">
        <div class="article__main">
            <x-section-head eyebrow="The basics" :title="e($service['what']['heading'])" />
            <p class="lead" data-reveal="up">{{ $service['intro'] }}</p>
            @foreach ($service['what']['body'] as $p)
                <p data-reveal="up">{{ $p }}</p>
            @endforeach
            @if (! empty($service['what']['note']))
                <p data-reveal="up">{{ $service['what']['note'] }}</p>
            @endif
        </div>
        <aside class="article__aside">
            <div class="panel panel--dark" data-reveal="card">
                <h3>{{ $service['what']['uses_heading'] ?? 'Common uses' }}</h3>
                <x-check-list :items="$service['what']['uses']" data-stagger="up" />
                @if (! empty($service['what']['fast_track']))
                    <p class="fast-track"><span>Fast track</span>{{ $service['what']['fast_track'] }}</p>
                @endif
            </div>
        </aside>
    </div>
</section>

{{-- Why professional --}}
<section class="section section--dark">
    <div class="container split split--center">
        <div>
            <x-section-head eyebrow="Precision & safety" :title="e($service['why']['heading'])" :intro="$service['why']['body']" />
        </div>
        @if ($service['why']['points'])
            <ol class="num-list" data-stagger="left">
                @foreach ($service['why']['points'] as $pt)
                    <li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $pt }}</li>
                @endforeach
            </ol>
        @endif
    </div>
</section>

<x-process-scroll :steps="$service['process']['steps']" :title="e($service['process']['heading'])"
    :intro="'Every ' . $short . ' job follows these steps — planned, safe and finished clean.'" />

{{-- Reasons --}}
<section class="section">
    <div class="container">
        <x-section-head eyebrow="Why choose us" :title="e($service['reasons']['heading'])" :center="true" />
        <div class="feature-grid" data-stagger="card">
            @foreach ($service['reasons']['items'] as [$title, $text])
                <article class="feature" data-tilt="5">
                    <span class="feature__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="feature__title">{{ $title }}</h3>
                    <p>{{ $text }}</p>
                    <span class="spotlight" aria-hidden="true"></span>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Sectors --}}
<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Where we work" :title="e($service['sectors']['heading'])" />
        <div class="industry-grid" data-stagger="card">
            @foreach ($service['sectors']['items'] as [$title, $text])
                <article class="industry" data-tilt="5">
                    <x-icon :name="$sectorIcon($title)" size="28" class="industry__icon" />
                    <h3>{{ $title }}</h3>
                    <p>{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Equipment --}}
<section class="section">
    <div class="container split split--center">
        <div class="media-3d" data-reveal="clip">
            <x-image :name="$service['image']" sizes="(min-width: 960px) 45vw, 100vw" data-parallax="0.08" />
        </div>
        <div>
            <x-section-head eyebrow="Technology" :title="e($service['equipment']['heading'])" />
            <ul class="spec-list spec-list--light" data-stagger="up">
                @foreach ($service['equipment']['items'] as $item)
                    <li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<x-coverage :title="e($service['name']) . ' across the UAE'" />

{{-- FAQ --}}
<section class="section">
    <div class="container faq-layout">
        <div class="faq-layout__aside">
            <x-section-head eyebrow="FAQ" :title="e($service['faq_heading'])" />
            <p class="section-intro" data-reveal="up">Something else you want to know? Call <a href="{{ tel_link() }}">{{ config('site.phone') }}</a> or send us a WhatsApp.</p>
            <p class="city-links" data-reveal="up">{{ $service['name'] }} near you:
                <a href="{{ route('location.show', 'dubai') }}">Dubai</a> ·
                <a href="{{ route('location.show', 'abu-dhabi') }}">Abu Dhabi</a> ·
                <a href="{{ route('location.show', 'sharjah') }}">Sharjah</a></p>
        </div>
        <x-faq :faqs="$service['faqs']" />
    </div>
</section>

{{-- Related --}}
<section class="section section--dark">
    <div class="container">
        <x-section-head eyebrow="Related services" title="Other services you may need" />
        <div class="bento bento--3" data-stagger="card">
            @foreach ($related as $r)
                <x-service-card :service="$r" />
            @endforeach
        </div>
    </div>
</section>

<x-quote-section :selected="$service['slug']" :title="'Get a quote for <span class=\'grad\'>' . e($short) . '</span>'" />

@endsection
