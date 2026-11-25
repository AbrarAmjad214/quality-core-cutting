{{--
    Inner-page hero: cinematic dark band, photo backdrop + 3D tilted photo card.
    The default slot holds the call-to-action buttons.
--}}
@props(['eyebrow' => null, 'title', 'lead' => null, 'image' => null, 'crumbs' => []])
<section class="page-hero">
    @if ($image)
        <div class="page-hero__backdrop" aria-hidden="true">
            <x-image :name="$image" sizes="100vw" alt="" data-parallax="0.12" />
        </div>
    @endif
    <div class="page-hero__floor" aria-hidden="true"></div>
    <div class="container page-hero__grid @if (! $image) page-hero__grid--solo @endif">
        <div class="page-hero__text">
            @if ($crumbs)
                <x-breadcrumbs :items="$crumbs" />
            @endif
            @if ($eyebrow)
                <p class="pill">{{ $eyebrow }}</p>
            @endif
            <h1 class="page-hero__title" data-split>{!! $title !!}</h1>
            @if ($lead)
                <p class="page-hero__lead" data-reveal="up" style="--d:.35s">{{ $lead }}</p>
            @endif
            @if (trim($slot))
                <div class="btn-row" data-reveal="up" style="--d:.5s">{{ $slot }}</div>
            @endif
        </div>
        @if ($image)
            <div class="page-hero__card" data-reveal="card" style="--d:.2s">
                <div class="tilt-card" data-tilt="8">
                    <x-image :name="$image" :eager="true" sizes="(min-width: 960px) 40vw, 100vw" />
                    <span class="tilt-card__glare" aria-hidden="true"></span>
                </div>
                <div class="float-badge">
                    <span class="float-badge__dot"></span>
                    <span><strong>GPR scanned</strong> before every cut</span>
                </div>
            </div>
        @endif
    </div>
</section>
