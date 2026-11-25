{{-- Services as a simple index list: name, short description, arrow --}}
@props(['services', 'tag' => 'h3'])
<ol {{ $attributes->merge(['class' => 'svc-list']) }}>
    @foreach ($services as $s)
        <li>
            <a href="{{ route('service.show', $s['slug']) }}" class="svc-list__row">
                <span class="svc-list__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <{{ $tag }} class="svc-list__name">{{ $s['name'] }}</{{ $tag }}>
                <span class="svc-list__desc">{{ $s['card'] }}</span>
                <x-icon name="arrow" size="22" class="svc-list__arrow" />
            </a>
        </li>
    @endforeach
</ol>
