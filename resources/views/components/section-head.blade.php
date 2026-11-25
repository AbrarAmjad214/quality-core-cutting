{{-- Section heading: small label, title (word-by-word reveal), optional intro --}}
@props(['eyebrow' => null, 'title', 'intro' => null, 'tag' => 'h2', 'center' => false])
<div {{ $attributes->class(['section-head', 'section-head--center' => $center]) }}>
    @if ($eyebrow)
        <p class="label">{{ $eyebrow }}</p>
    @endif
    <{{ $tag }} class="section-title" data-split>{!! $title !!}</{{ $tag }}>
    @if ($intro)
        <p class="section-intro" data-reveal="up" style="--d:.2s">{{ $intro }}</p>
    @endif
</div>
