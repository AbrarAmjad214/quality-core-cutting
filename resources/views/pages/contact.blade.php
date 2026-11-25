@extends('layouts.app')

@section('title', 'Contact Us | Free Quote — Quality Core Cutting UAE')
@section('description', 'Contact Quality Core Cutting UAE for concrete cutting and core cutting quotes in Dubai, Sharjah and Abu Dhabi. Call +971 50 758 9374 — available 24/7.')

@php($crumbs = [['Home', route('home')], ['Contact Us', null]])
@push('schema')
    @include('partials.schema.breadcrumb', ['items' => $crumbs])
@endpush

@section('content')

<x-page-hero eyebrow="Get in touch" title="Contact Quality Core Cutting <span class='grad'>UAE</span>"
    lead="Call, WhatsApp or send the form — our team is available 24/7 for concrete cutting, core cutting and scanning across the Emirates."
    :crumbs="$crumbs" />

<section class="section">
    <div class="container contact">
        <ul class="contact-cards" data-stagger="card">
            <li><a class="contact-card" href="{{ tel_link() }}" data-tilt="5"><x-icon name="phone" size="26" /><span><small>Phone (24/7)</small>{{ config('site.phone') }}</span></a></li>
            <li><a class="contact-card" href="{{ whatsapp_link() }}" target="_blank" rel="noopener" data-tilt="5"><x-icon name="whatsapp" size="26" /><span><small>WhatsApp</small>Chat with our team</span></a></li>
            <li><a class="contact-card" href="mailto:{{ config('site.email') }}" data-tilt="5"><x-icon name="mail" size="26" /><span><small>Email</small>{{ config('site.email') }}</span></a></li>
            <li><a class="contact-card" href="{{ config('site.map_url') }}" target="_blank" rel="noopener" data-tilt="5"><x-icon name="pin" size="26" /><span><small>Location</small>{{ config('site.address.label') }}</span></a></li>
            <li><div class="contact-card"><x-icon name="clock" size="26" /><span><small>Hours</small>{{ config('site.hours') }}</span></div></li>
        </ul>
        <div class="contact__form panel" id="quote" data-reveal="card">
            <x-section-head eyebrow="Free quote" title="We’d love to hear from you"
                intro="Tell us about the job — location, what needs cutting or drilling, and your timeline. We’ll reply quickly with a clear price." />
            <x-quote-form id="contact-form" />
        </div>
    </div>
</section>

<x-coverage />

@endsection
