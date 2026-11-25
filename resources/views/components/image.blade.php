{{--
    Responsive image from resources/data/images.php
    <x-image name="core-drilling-wall" sizes="(min-width: 960px) 50vw, 100vw" :eager="true" />
--}}
@props(['name', 'sizes' => '100vw', 'eager' => false, 'alt' => null])
@php
    $img = \App\Support\Content::image($name);
    $srcset = collect($img['sizes'])->map(fn ($w) => asset("assets/images/{$name}-{$w}.webp") . " {$w}w")->implode(', ');
    $default = $img['sizes'][min(1, count($img['sizes']) - 1)];
@endphp
<img {{ $attributes }}
     src="{{ asset("assets/images/{$name}-{$default}.webp") }}"
     srcset="{{ $srcset }}"
     sizes="{{ $sizes }}"
     width="{{ $img['w'] }}" height="{{ $img['h'] }}"
     alt="{{ $alt ?? $img['alt'] }}"
     @if ($eager) fetchpriority="high" @else loading="lazy" @endif
     decoding="async">
