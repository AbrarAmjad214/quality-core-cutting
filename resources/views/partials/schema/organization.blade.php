{{-- LocalBusiness (GeneralContractor) schema — on every page. Details come from config/site.php --}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'GeneralContractor',
        '@id' => url('/') . '#organization',
        'name' => config('site.name'),
        'url' => url('/'),
        'logo' => asset(config('site.logo_png')),
        'image' => asset(config('site.og_image')),
        'description' => config('site.description'),
        'telephone' => config('site.phone_raw'),
        'email' => config('site.email'),
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => config('site.address.locality'),
            'addressRegion' => config('site.address.region'),
            'addressCountry' => config('site.address.country'),
        ],
        'areaServed' => array_map(fn ($c) => ['@type' => 'City', 'name' => $c], config('site.area_served')),
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'opens' => '00:00',
            'closes' => '23:59',
        ]],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => config('site.phone_raw'),
            'email' => config('site.email'),
            'contactType' => 'customer service',
            'areaServed' => 'AE',
            'availableLanguage' => ['English', 'Arabic'],
        ],
        'knowsAbout' => array_values(array_column(\App\Support\Content::services(), 'name')),
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Concrete cutting services',
            'itemListElement' => array_values(array_map(fn ($s) => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => $s['name'], 'url' => route('service.show', $s['slug'])],
            ], \App\Support\Content::services())),
        ],
    ];
    if (count(config('site.social'))) {
        $schema['sameAs'] = array_values(config('site.social'));
    }
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
