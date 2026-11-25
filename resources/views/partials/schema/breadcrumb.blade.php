{{--
    BreadcrumbList schema — same items as the visible <x-breadcrumbs>.
    @include('partials.schema.breadcrumb', ['items' => [['Home', url('/')], ['Page', null]]])
    (the last item has no link; the current URL is used)
--}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn ($item, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item[0],
            'item' => $item[1] ?? url()->current(),
        ])->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
