@extends('layouts.app')

@section('title', 'Page Not Found | Quality Core Cutting UAE')
@section('description', 'The page you were looking for could not be found.')
@section('robots', 'noindex, follow')

@section('content')
<x-page-hero eyebrow="Error 404" title="This page has been <span class='grad'>cut out</span>"
    lead="It may have moved when we rebuilt the website. Try one of our services below, or get in touch.">
    <a href="{{ route('home') }}" class="btn btn--primary">Back to home <x-icon name="arrow" size="18" /></a>
    <a href="{{ route('contact') }}" class="btn btn--glass">Contact us</a>
</x-page-hero>
<section class="section section--dark">
    <div class="container">
        <div class="bento" data-stagger="card">
            @foreach (array_values(\App\Support\Content::services()) as $i => $s)
                <x-service-card :service="$s" :size="$i < 2 ? 'lg' : null" />
            @endforeach
        </div>
    </div>
</section>
@endsection
