@extends('layouts.app')

@section('title', 'Our Projects | Concrete Cutting Work Across the UAE')
@section('description', 'Concrete cutting, core cutting, floor saw cutting and controlled demolition projects completed by Quality Core Cutting UAE in Dubai, Sharjah and Abu Dhabi.')

@php
    $crumbs = [['Home', route('home')], ['Projects', null]];
    // Photos of the cutting methods we use (captions describe the method, not a specific client project)
    $gallery = [
        ['core-drilling-wall', 'Core drilling a reinforced concrete wall', 'core-cutting'],
        ['wall-saw-cutting-slab', 'Wall saw cutting a thick concrete section', 'wall-saw-cutting'],
        ['floor-saw-cutting-car-park', 'Floor saw cutting in a car park', 'floor-saw-cutting'],
        ['concrete-scanning-column', 'GPR scanning a column before cutting', 'concrete-scanning'],
        ['wire-saw-cutting-site', 'Cutting large concrete blocks on site', 'wire-saw-cutting'],
        ['core-cutting-pipe-opening', 'Core cutting a pipe opening', 'core-cutting'],
        ['gpr-scan-results', 'GPR scan showing reinforcement layout', 'concrete-scanning'],
        ['core-drilling-floor', 'Diamond drilling through a slab', 'diamond-drilling'],
    ];
@endphp
@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
@endpush

@section('content')

<x-page-hero eyebrow="Recent work" title="Our Concrete Cutting &amp; Core Cutting <span class='grad'>Projects</span>"
    lead="The kind of cutting, drilling and scanning work our teams carry out for contractors, facility managers and property owners across the UAE."
    image="wire-saw-cutting-site" :crumbs="$crumbs">
    <a href="{{ route('contact') }}#quote" class="btn btn--primary">Discuss your project <x-icon name="arrow" size="18" /></a>
</x-page-hero>

<section class="section section--dark">
    <div class="container">
        <x-section-head eyebrow="Case studies" title="Recent projects in Dubai &amp; Abu Dhabi" />
        <div class="projects">
            @foreach ($company['projects'] as $p)
                @include('partials.project-card', ['p' => $p])
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <x-section-head eyebrow="On site" title="Our cutting methods in action"
            intro="Core drilling, wall sawing, floor sawing, wire sawing and GPR scanning — the methods behind every project." />
        <ul class="gallery" data-stagger="card">
            @foreach ($gallery as [$img, $caption, $slug])
                <li>
                    <a href="{{ route('service.show', $slug) }}" class="gallery__item" data-tilt="5">
                        <x-image :name="$img" sizes="(min-width: 1100px) 33vw, (min-width: 640px) 50vw, 100vw" />
                        <span class="gallery__cap">{{ $caption }} <x-icon name="arrow" size="16" /></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Industries" title="Industries we serve" />
        <div class="industry-grid" data-stagger="card">
            @foreach ($company['industries'] as $i)
                <article class="industry" data-tilt="5">
                    <x-icon :name="$i['icon']" size="28" class="industry__icon" />
                    <h3>{{ $i['title'] }}</h3>
                    <p>{{ $i['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<x-quote-section title="Have a project? Get a <span class='grad'>free quote</span>" />

@endsection
