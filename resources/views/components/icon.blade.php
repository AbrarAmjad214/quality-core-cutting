@props(['name', 'size' => 24])
@php($sprite = asset_v('assets/icons/sprite.svg'))
<svg {{ $attributes->merge(['class' => 'icon']) }} width="{{ $size }}" height="{{ $size }}" aria-hidden="true" focusable="false"><use href="{{ $sprite }}#{{ $name }}"></use></svg>
