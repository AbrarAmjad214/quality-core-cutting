{{-- Numbered process steps. $steps = [[title, text], ...] --}}
@props(['steps'])
<ol {{ $attributes->merge(['class' => 'steps']) }}>
    @foreach ($steps as [$title, $text])
        <li class="step">
            <span class="step__num">{{ $loop->iteration }}</span>
            <div>
                <h3 class="step__title">{{ $title }}</h3>
                <p class="step__text">{{ $text }}</p>
            </div>
        </li>
    @endforeach
</ol>
