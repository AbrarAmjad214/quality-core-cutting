@extends('layouts.app')

@section('title', 'Core Cutting & Concrete Cutting UAE | Quality Core Cutting')
@section('description', 'Concrete cutting, core cutting, wall saw & wire saw cutting and GPR concrete scanning in Dubai, Sharjah & Abu Dhabi. 24/7 service. Free quotes.')

@push('styles')
    {{-- hero photo is the LCP element: start downloading it immediately --}}
    <link rel="preload" as="image" type="image/webp" fetchpriority="high"
          imagesrcset="{{ asset('assets/images/core-drilling-wall-480.webp') }} 480w, {{ asset('assets/images/core-drilling-wall-800.webp') }} 800w, {{ asset('assets/images/core-drilling-wall-1200.webp') }} 1200w"
          imagesizes="100vw">
@endpush

@section('content')

{{-- ============ HERO: full-bleed site photo with depth parallax + drifting dust ============ --}}
<section class="hero" data-hero>
    <div class="hero__media" data-depth="0.035" aria-hidden="true">
        <x-image name="core-drilling-wall" :eager="true" sizes="100vw" class="hero__img" alt="" />
    </div>
    <canvas class="hero__dust" data-dust aria-hidden="true"></canvas>
    <div class="hero__shade" aria-hidden="true"></div>

    <div class="container hero__inner" data-depth="-0.015">
        <p class="hero__place" data-reveal="up">Abu Dhabi · Dubai · Sharjah · all 7 Emirates — available 24/7</p>
        <h1 class="hero__title" data-split>Concrete Cutting &amp; Core Cutting Company in Dubai, Sharjah &amp; <span class="accent">Abu Dhabi, UAE</span></h1>
        <p class="hero__lead" data-reveal="up" style="--d:.45s">Core drilling, wall sawing, wire sawing and floor sawing — with GPR concrete scanning before every cut. Trusted by contractors, MEP teams and property owners across the Emirates.</p>
        <div class="btn-row" data-reveal="up" style="--d:.6s">
            <a href="#quote" class="btn btn--primary">Get a free quote <x-icon name="arrow" size="18" /></a>
            <a href="{{ tel_link() }}" class="btn btn--glass"><x-icon name="phone" size="18" /> {{ config('site.phone') }}</a>
        </div>
    </div>

    <div class="container hero__stats">
        <x-stats :stats="$company['stats']" class="stats--hero" />
    </div>
</section>

<x-marquee :items="array_column($services, 'name')" />

{{-- ============ ABOUT ============ --}}
<section class="section">
    <div class="container about">
        <div class="about__media">
            <div class="about__img about__img--a" data-reveal="clip">
                <x-image name="wall-saw-blade-on-site" sizes="(min-width: 960px) 28vw, 60vw" data-parallax="0.08" />
            </div>
            <div class="about__img about__img--b" data-reveal="clip" style="--d:.15s">
                <x-image name="concrete-scanning-column" sizes="(min-width: 960px) 30vw, 70vw" data-parallax="0.12" />
            </div>
            <div class="about__badge glass-light" data-reveal="pop" style="--d:.4s">
                <strong data-count="10" data-suffix="+">10+</strong>
                <span>years of concrete cutting across the UAE</span>
            </div>
        </div>
        <div class="about__text">
            <x-section-head eyebrow="About us" title="Dubai &amp; Abu Dhabi’s trusted concrete cutting specialists" />
            <p class="lead" data-reveal="up">We cut clean, accurate openings in concrete — for pipes, ducts, doors and whole structural sections — without damaging what’s around them.</p>
            <p data-reveal="up">Quality Core Cutting UAE delivers precision concrete cutting and core cutting to construction sites, factories and buildings across Dubai, Sharjah, Abu Dhabi and the rest of the UAE. Every project starts with concrete scanning to map out rebar and hidden utilities, followed by the right cutting method for the job.</p>
            <x-check-list :items="$company['key_points']" data-stagger="up" />
            <a href="{{ route('about') }}" class="btn btn--dark" data-reveal="up">More about us <x-icon name="arrow" size="18" /></a>
        </div>
    </div>
</section>

{{-- ============ SERVICES BENTO ============ --}}
<section class="section section--dark" id="services">
    <div class="container">
        <div class="head-row">
            <x-section-head eyebrow="What we do" title="Concrete cutting &amp; core cutting services in Dubai, Sharjah &amp; Abu Dhabi" />
            <a href="{{ route('services') }}" class="btn btn--glass" data-reveal="up">All services <x-icon name="arrow" size="18" /></a>
        </div>
        <div class="bento" data-stagger="card">
            @foreach (array_values($services) as $i => $s)
                <x-service-card :service="$s" :size="$i < 2 ? 'lg' : null" />
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PROCESS (pinned horizontal scroll) ============ --}}
<x-process-scroll :steps="$company['process']" title="Our concrete cutting &amp; core cutting process"
    intro="The same four steps on every job — whether it’s one core hole or a full structural opening."
    :images="['gpr-floor-scanning', 'concrete-scanning-tablet', 'core-drilling-floor', 'core-cutting-pipe-opening']" />

{{-- ============ WHY US ============ --}}
<section class="section">
    <div class="container">
        <x-section-head eyebrow="Why choose us" title="Why choose Quality Core Cutting UAE?" :center="true"
            intro="Six reasons contractors and facility managers keep calling us back." />
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

{{-- ============ PROJECTS ============ --}}
<section class="section section--dark">
    <div class="container">
        <div class="head-row">
            <x-section-head eyebrow="Recent work" title="Recent concrete cutting &amp; core cutting projects" />
            <a href="{{ route('projects') }}" class="btn btn--glass" data-reveal="up">View projects <x-icon name="arrow" size="18" /></a>
        </div>
        <div class="projects">
            @foreach ($company['projects'] as $p)
                @include('partials.project-card', ['p' => $p])
            @endforeach
        </div>
    </div>
</section>

{{-- ============ TESTIMONIALS ============ --}}
<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Client feedback" title="What our clients say" :center="true" />
        <div class="testimonials" data-stagger="card">
            @foreach ($company['testimonials'] as $t)
                <figure class="testimonial">
                    <x-icon name="quote" size="34" class="testimonial__mark" />
                    <blockquote><p>{{ $t['quote'] }}</p></blockquote>
                    <figcaption>
                        <span class="testimonial__avatar" aria-hidden="true">{{ substr($t['who'], 0, 1) }}</span>
                        <span><strong>{{ $t['who'] }}</strong>{{ $t['where'] }}</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ EQUIPMENT & SAFETY ============ --}}
<section class="section" id="equipment">
    <div class="container split">
        <div class="panel panel--dark" data-reveal="card">
            <x-section-head eyebrow="Technology" title="Concrete cutting equipment we use in Dubai &amp; Abu Dhabi" />
            <ul class="spec-list" data-stagger="up">
                @foreach ($company['equipment'] as $item)
                    <li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        <div class="panel" data-reveal="card" style="--d:.15s">
            <x-section-head eyebrow="Compliance" title="Safety &amp; compliance you can rely on" :intro="$company['compliance']['text']" />
            <x-check-list :items="$company['compliance']['points']" data-stagger="up" />
        </div>
    </div>
</section>

{{-- ============ INDUSTRIES ============ --}}
<section class="section section--soft">
    <div class="container">
        <x-section-head eyebrow="Industries" title="Industries we serve across Dubai, Sharjah &amp; Abu Dhabi" />
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

<x-coverage />

{{-- ============ FAQ ============ --}}
<section class="section" id="faq">
    <div class="container faq-layout">
        <div class="faq-layout__aside">
            <x-section-head eyebrow="FAQ" title="Frequently asked questions" />
            <p class="section-intro" data-reveal="up">Can’t find your answer? Call <a href="{{ tel_link() }}">{{ config('site.phone') }}</a> — we answer 24/7.</p>
        </div>
        <x-faq :faqs="$company['faqs']" />
    </div>
</section>

<x-quote-section title="Get a free quote for your <span class='grad'>cutting job</span>" />

@endsection
