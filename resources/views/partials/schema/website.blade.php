{{-- WebSite schema — loaded on every page --}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => url('/') . '#website',
        'url' => url('/'),
        'name' => config('site.name'),
        'inLanguage' => 'en-US',
        'publisher' => ['@id' => url('/') . '#organization'],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
