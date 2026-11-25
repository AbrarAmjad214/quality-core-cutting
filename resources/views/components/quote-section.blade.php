{{-- Closing call-to-action: contact details + quote form on a glowing dark band --}}
@props(['selected' => null, 'title' => 'Tell us about your job'])
<section class="section quote-section" id="quote">
    <div class="quote-section__glow" aria-hidden="true"></div>
    <div class="container quote-section__grid">
        <div class="quote-section__intro">
            <p class="label">Free quote · No obligation</p>
            <h2 class="section-title" data-split>{!! $title !!}</h2>
            <p class="section-intro">Send us the location, what needs cutting, drilling or scanning, and roughly how big. We’ll come back quickly with a clear price — no hidden costs.</p>
            <ul class="contact-tiles" data-stagger="up">
                <li><a href="{{ tel_link() }}"><x-icon name="phone" size="22" /><span><small>Call 24/7</small>{{ config('site.phone') }}</span></a></li>
                <li><a href="{{ whatsapp_link() }}" target="_blank" rel="noopener"><x-icon name="whatsapp" size="22" /><span><small>WhatsApp</small>Send a message</span></a></li>
                <li><a href="mailto:{{ config('site.email') }}"><x-icon name="mail" size="22" /><span><small>Email</small>{{ config('site.email') }}</span></a></li>
            </ul>
        </div>
        <div class="quote-section__form glass" data-reveal="card">
            <x-quote-form :selected="$selected" />
        </div>
    </div>
</section>
