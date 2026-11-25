{{--
    Service schema (service pages)
    @include('partials.schema.service', ['service' => $service])
--}}
@php
    $img = \App\Support\Content::image($service['image']);
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => url()->current() . '#service',
        'name' => $service['name'],
        'serviceType' => $service['name'],
        'description' => $service['description'],
        'url' => url()->current(),
        'image' => asset("assets/images/{$service['image']}-" . end($img['sizes']) . '.webp'),
        'provider' => ['@id' => url('/') . '#organization'],
        'areaServed' => array_map(fn ($c) => ['@type' => 'City', 'name' => $c], config('site.area_served')),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
