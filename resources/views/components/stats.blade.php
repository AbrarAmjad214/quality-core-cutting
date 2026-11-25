{{-- Stats with count-up animation (numbers like "10+" or "100%" count up; "24/7" stays as text) --}}
@props(['stats'])
<dl {{ $attributes->merge(['class' => 'stats']) }} data-stagger="up">
    @foreach ($stats as $s)
        @php(preg_match('/^(\d+)(\D*)$/', $s['value'], $m))
        <div class="stat">
            <dt class="stat__value" @if ($m) data-count="{{ $m[1] }}" data-suffix="{{ $m[2] }}" @endif>{{ $s['value'] }}</dt>
            <dd class="stat__label">{{ $s['label'] }}</dd>
        </div>
    @endforeach
</dl>
