@php($services = \App\Support\Content::services())
<footer class="site-footer">
    <div class="container site-footer__grid">
        <div class="site-footer__brand">
            <a href="{{ route('home') }}" class="logo logo--footer" aria-label="{{ config('site.name') }} — home">
                <img src="{{ asset(config('site.logo')) }}" alt="{{ config('site.name') }}" width="548" height="263" loading="lazy">
            </a>
            <p>Concrete cutting, core cutting, wall saw and wire saw cutting, concrete scanning and civil work for contractors and property owners across the UAE.</p>
            <a href="{{ route('contact') }}#quote" class="btn btn--primary btn--sm">Get a free quote</a>
        </div>

        <nav class="site-footer__col" aria-label="Company">
            <h2 class="site-footer__title">Company</h2>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('services') }}">Our Services</a></li>
                <li><a href="{{ route('projects') }}">Our Projects</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
            <h2 class="site-footer__title site-footer__title--gap">Areas</h2>
            <ul>
                <li><a href="{{ route('location.show', 'dubai') }}">Core cutting Dubai</a></li>
                <li><a href="{{ route('location.show', 'abu-dhabi') }}">Core cutting Abu Dhabi</a></li>
                <li><a href="{{ route('location.show', 'sharjah') }}">Core cutting Sharjah</a></li>
            </ul>
        </nav>

        <nav class="site-footer__col" aria-label="Services">
            <h2 class="site-footer__title">Services</h2>
            <ul class="site-footer__services">
                @foreach ($services as $s)
                    <li><a href="{{ route('service.show', $s['slug']) }}">{{ $s['name'] }}</a></li>
                @endforeach
            </ul>
        </nav>

        <div class="site-footer__col">
            <h2 class="site-footer__title">Contact</h2>
            <ul class="site-footer__contact">
                <li><x-icon name="phone" size="18" /><a href="{{ tel_link() }}">{{ config('site.phone') }}</a></li>
                <li><x-icon name="mail" size="18" /><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
                <li><x-icon name="pin" size="18" /><span>{{ config('site.address.label') }}</span></li>
                <li><x-icon name="clock" size="18" /><span>{{ config('site.hours') }}</span></li>
            </ul>
        </div>
    </div>
    <div class="container" aria-hidden="true"><p class="footer-mark">Quality Core Cutting</p></div>
    <div class="container site-footer__bottom">
        <p>&copy; {{ date('Y') }} {{ config('site.name') }}. All rights reserved.</p>
        <p>Serving {{ implode(' · ', array_slice(config('site.area_served'), 0, 3)) }} &amp; all Emirates</p>
        <p class="site-credit">Designed &amp; developed by <a href="https://rabrar.com/" target="_blank" rel="noopener">rabrar.com</a></p>
    </div>
</footer>

{{-- Floating WhatsApp / call buttons --}}
<div class="float-actions">
    <a href="{{ whatsapp_link() }}" class="float-btn float-btn--wa" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><x-icon name="whatsapp" size="28" /></a>
    <a href="{{ tel_link() }}" class="float-btn float-btn--call" aria-label="Call {{ config('site.phone') }}"><x-icon name="phone" size="24" /></a>
</div>

{{-- ================= Scripts ================= --}}
<script src="{{ asset_v('assets/js/app.js') }}" defer></script>
@include('partials.analytics')
@stack('scripts')
</body>
</html>
