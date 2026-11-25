@extends('layouts.app')

@section('title', 'Our Concrete Cutting Services | Quality Core Cutting UAE')
@section('description', 'Core cutting, wall, wire & floor saw cutting, GPR scanning, diamond drilling, anchoring, demolition and civil work in Dubai, Sharjah & Abu Dhabi.')

@php
    $crumbs = [['Home', route('home')], ['Services', null]];
    $list = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Concrete cutting services',
        'itemListElement' => array_values(array_map(fn ($s, $i) => [
            '@type' => 'ListItem', 'position' => $i + 1, 'name' => $s['name'], 'url' => route('service.show', $s['slug']),
        ], $services, array_keys(array_values($services)))),
    ];
@endphp
@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
    <script type="application/ld+json">{!! json_encode($list, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')

<x-page-hero eyebrow="Full service range" title="Concrete Cutting &amp; Core Cutting Services in <span class='grad'>the UAE</span>"
    lead="From a single core hole to the controlled removal of a whole structure — every job starts with GPR concrete scanning and ends with a clean, finished handover."
    image="core-drilling-floor" :crumbs="$crumbs">
    <a href="{{ route('contact') }}#quote" class="btn btn--primary">Get a free quote <x-icon name="arrow" size="18" /></a>
    <a href="{{ tel_link() }}" class="btn btn--glass"><x-icon name="phone" size="18" /> {{ config('site.phone') }}</a>
</x-page-hero>

<x-marquee :items="array_column($services, 'name')" />

<section class="section section--dark">
    <div class="container">
        <x-section-head eyebrow="Choose a service" title="{{ count($services) }} specialist services, one contractor"
            intro="Pick a service to see how we do it, the equipment we use, and answers to common questions." />
        <div class="bento" data-stagger="card">
            @foreach (array_values($services) as $i => $s)
                <x-service-card :service="$s" tag="h2" :size="$i < 2 ? 'lg' : null" />
            @endforeach
        </div>
    </div>
</section>

<x-process-scroll :steps="$company['process']" title="The same safe process on every job"
    intro="Scanning, planning, clean cutting and a tidy handover — no shortcuts."
    :images="['gpr-floor-scanning', 'concrete-scanning-tablet', 'core-drilling-floor', 'core-cutting-pipe-opening']" />

<section class="section">
    <div class="container faq-layout">
        <div class="faq-layout__aside">
            <x-section-head eyebrow="FAQ" title="Common questions about our services" />
        </div>
        <x-faq :faqs="array_slice($company['faqs'], 0, 5)" />
    </div>
</section>

<x-quote-section />

@endsection
