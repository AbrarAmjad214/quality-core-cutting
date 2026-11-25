@extends('layouts.app')

@section('title', 'About Us | Quality Core Cutting UAE')
@section('description', 'Quality Core Cutting UAE is a specialist concrete cutting and core cutting company serving contractors and property owners across Dubai, Sharjah and Abu Dhabi.')

@php($crumbs = [['Home', route('home')], ['About Us', null]])
@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
@endpush

@section('content')

<x-page-hero eyebrow="Abu Dhabi · Dubai · Sharjah · All 7 Emirates" title="About Quality Core Cutting <span class='grad'>Abu Dhabi, UAE</span>"
    lead="A trusted concrete cutting and core cutting company serving Dubai, Sharjah, Abu Dhabi, and every Emirate across the UAE."
    image="wall-saw-cutting-indoor" :crumbs="$crumbs">
    <a href="{{ route('contact') }}#quote" class="btn btn--primary">Get a free quote <x-icon name="arrow" size="18" /></a>
    <a href="{{ tel_link() }}" class="btn btn--glass"><x-icon name="phone" size="18" /> {{ config('site.phone') }}</a>
</x-page-hero>

<section class="section">
    <div class="container about">
        <div class="about__media">
            <div class="about__img about__img--a" data-reveal="clip">
                <x-image name="wall-saw-blade-on-site" sizes="(min-width: 960px) 28vw, 60vw" data-parallax="0.08" />
            </div>
            <div class="about__img about__img--b" data-reveal="clip" style="--d:.15s">
                <x-image name="core-drilling-floor" sizes="(min-width: 960px) 30vw, 70vw" data-parallax="0.12" />
            </div>
            <div class="about__badge glass-light" data-reveal="pop" style="--d:.4s">
                <strong>24/7</strong>
                <span>emergency cutting response across the UAE</span>
            </div>
        </div>
        <div class="about__text">
            <x-section-head eyebrow="Our story" title="Built to be the concrete cutting partner the UAE could rely on" />
            <p class="lead" data-reveal="up">Quality Core Cutting UAE is a specialist concrete cutting company built around one goal — delivering precise, safe, and reliable cutting solutions for the UAE’s construction industry.</p>
            <p data-reveal="up">What started as a small team of core cutting technicians has grown into a full-service concrete cutting company, now handling core cutting, wall saw cutting, wire saw cutting, floor saw cutting, concrete scanning, chemical anchoring, and controlled demolition for projects of every size.</p>
            <p data-reveal="up">Over the years, we’ve worked alongside main contractors, MEP teams, structural engineers, and property owners on residential villas, commercial towers, industrial warehouses, and infrastructure sites throughout the UAE. Every project has reinforced the same principle our company was founded on: concrete cutting done right the first time saves clients time, money, and risk.</p>
        </div>
    </div>
</section>

<section class="section section--dark section--tight-top">
    <div class="container">
        <x-stats :stats="$company['stats']" class="stats--hero glass" />
        <div class="mv" data-stagger="card">
            <article class="mv__card">
                <p class="label">Mission</p>
                <p class="mv__text">{{ $company['mission'] }}</p>
            </article>
            <article class="mv__card">
                <p class="label">Vision</p>
                <p class="mv__text">{{ $company['vision'] }}</p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="head-row">
            <x-section-head eyebrow="What we do" title="Concrete cutting &amp; structural services" />
            <a href="{{ route('services') }}" class="btn btn--dark" data-reveal="up">All services <x-icon name="arrow" size="18" /></a>
        </div>
        <div class="bento bento--light" data-stagger="card">
            @foreach (array_values($services) as $i => $s)
                <x-service-card :service="$s" :size="$i < 2 ? 'lg' : null" />
            @endforeach
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Why choose us" title="Why contractors choose us" :center="true" />
        <div class="feature-grid" data-stagger="card">
            @foreach ($company['why'] as $f)
                <article class="feature" data-tilt="5">
                    <span class="feature__icon"><x-icon :name="$f['icon']" size="26" /></span>
                    <h3 class="feature__title">{{ $f['title'] }}</h3>
                    <p>{{ $f['text'] }}</p>
                    <span class="spotlight" aria-hidden="true"></span>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container split split--center">
        <x-section-head eyebrow="Compliance" title="Safety &amp; compliance you can rely on" :intro="$company['compliance']['text']" />
        <div class="panel panel--dark" data-reveal="card">
            <x-check-list :items="$company['compliance']['points']" data-stagger="up" />
        </div>
    </div>
</section>

<x-quote-section />

@endsection
