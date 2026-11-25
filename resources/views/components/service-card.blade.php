{{-- Service card: photo card with 3D tilt + cursor spotlight. --}}
@props(['service', 'image' => true, 'tag' => 'h3', 'index' => null, 'size' => null])
<article {{ $attributes->class(['svc-card', 'svc-card--' . $size => $size]) }} data-tilt="6">
    @if ($image)
        <div class="svc-card__media">
            <x-image :name="$service['image']" sizes="(min-width: 1100px) 33vw, (min-width: 640px) 50vw, 100vw" />
        </div>
    @endif
    <div class="svc-card__body">
        <span class="svc-card__icon"><x-icon :name="$service['icon']" size="24" /></span>
        <{{ $tag }} class="svc-card__title">
            <a href="{{ route('service.show', $service['slug']) }}">{{ $service['name'] }}</a>
        </{{ $tag }}>
        <p class="svc-card__text">{{ $service['card'] }}</p>
        <span class="svc-card__more" aria-hidden="true">Explore <x-icon name="arrow" size="16" /></span>
    </div>
    <span class="spotlight" aria-hidden="true"></span>
</article>
