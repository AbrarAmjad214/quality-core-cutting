@php($svc = \App\Support\Content::service($p['service']))
<article class="project" data-reveal="card">
    <div class="project__media">
        <x-image :name="$p['image']" sizes="(min-width: 960px) 40vw, 100vw" data-parallax="0.06" />
    </div>
    <div class="project__body">
        <p class="project__meta"><x-icon name="pin" size="16" /> {{ $p['location'] }}</p>
        <h3 class="project__title">{{ $p['title'] }}</h3>
        <p class="project__text">{{ $p['text'] }}</p>
        @if ($svc)
            <a href="{{ route('service.show', $svc['slug']) }}" class="chip">{{ $svc['name'] }}</a>
        @endif
    </div>
</article>
