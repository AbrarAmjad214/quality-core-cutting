{{-- Service areas band --}}
@props(['title' => 'Concrete cutting &amp; core cutting across the UAE', 'text' => null])
<section class="areas">
    <div class="areas__glow" aria-hidden="true"></div>
    <div class="container areas__grid">
        <div>
            <p class="label">Coverage</p>
            <h2 class="section-title" data-split>{!! $title !!}</h2>
            <p class="section-intro">{{ $text ?? \App\Support\Content::company()['coverage_text'] }}</p>
        </div>
        <ul class="areas__list" aria-label="Areas we serve" data-stagger="pop">
            @php($cityPages = ['Dubai' => 'dubai', 'Abu Dhabi' => 'abu-dhabi', 'Sharjah' => 'sharjah'])
            @foreach (config('site.area_served') as $area)
                @if (isset($cityPages[$area]))
                    <li><a href="{{ route('location.show', $cityPages[$area]) }}"><x-icon name="pin" size="18" /> {{ $area }} <x-icon name="arrow" size="16" class="areas__go" /></a></li>
                @else
                    <li><span><x-icon name="pin" size="18" /> {{ $area }}</span></li>
                @endif
            @endforeach
        </ul>
    </div>
</section>
