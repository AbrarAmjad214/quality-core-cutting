{{--
    Pinned horizontal-scroll process (desktop). On mobile / reduced motion it
    becomes a normal vertical list. $steps = [[title, text], ...]
--}}
@props(['steps', 'title', 'intro' => null, 'images' => []])
<section class="hscroll" data-hscroll>
    <div class="hscroll__sticky">
        <div class="container hscroll__head">
            <div>
                <p class="label">How we work</p>
                <h2 class="section-title" data-split>{!! $title !!}</h2>
            </div>
            @if ($intro)
                <p class="section-intro">{{ $intro }}</p>
            @endif
        </div>
        <div class="hscroll__viewport">
            <ol class="hscroll__track" data-hscroll-track>
                @foreach ($steps as [$stepTitle, $text])
                    <li class="step-panel">
                        @if (! empty($images[$loop->index]))
                            <div class="step-panel__media">
                                <x-image :name="$images[$loop->index]" sizes="(min-width: 1024px) 30vw, 100vw" alt="" />
                            </div>
                        @endif
                        <span class="step-panel__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="step-panel__title">{{ $stepTitle }}</h3>
                        <p class="step-panel__text">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="container"><div class="hscroll__bar" aria-hidden="true"><span></span></div></div>
    </div>
</section>
