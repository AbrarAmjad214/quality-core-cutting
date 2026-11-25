{{-- WebPage schema — uses the page's <title> and meta description (passed in from the header) --}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => url()->current() . '#webpage',
        'url' => url()->current(),
        'name' => $title,
        'description' => $description,
        'inLanguage' => 'en-AE',
        'isPartOf' => ['@id' => url('/') . '#website'],
        'about' => ['@id' => url('/') . '#organization'],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
