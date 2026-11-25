@props(['items'])
<ul {{ $attributes->merge(['class' => 'check-list']) }}>
    @foreach ($items as $item)
        <li><x-icon name="check" size="20" /><span>{{ $item }}</span></li>
    @endforeach
</ul>
