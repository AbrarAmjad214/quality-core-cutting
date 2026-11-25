{{-- Infinite ticker of service names (pure CSS animation) --}}
@props(['items'])
<div class="marquee" aria-hidden="true">
    <div class="marquee__track">
        @foreach ([1, 2] as $copy)
            <ul class="marquee__group">
                @foreach ($items as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>
