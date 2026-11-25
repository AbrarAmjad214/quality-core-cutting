{{--
    City landing page schema: a Service offered by the business in one city,
    with the services list as an OfferCatalog.
    @include('partials.schema.location', ['location' => $location])
--}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => url()->current() . '#service',
        'name' => $location['h1'],
        'serviceType' => 'Core cutting and concrete cutting',
        'description' => $location['description'],
        'url' => url()->current(),
        'provider' => ['@id' => url('/') . '#organization'],
        'areaServed' => [
            '@type' => 'City',
            'name' => $location['city'],
            'containedInPlace' => ['@type' => 'Country', 'name' => 'United Arab Emirates'],
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Concrete cutting services in ' . $location['city'],
            'itemListElement' => array_values(array_map(fn ($s) => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => $s['name'] . ' in ' . $location['city'], 'url' => route('service.show', $s['slug'])],
            ], \App\Support\Content::services())),
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
