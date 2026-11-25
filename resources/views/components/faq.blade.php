{{--
    FAQ list using native <details> (works without JavaScript).
    Also outputs the FAQPage schema for the same questions.
--}}
@props(['faqs'])
<div {{ $attributes->merge(['class' => 'faq']) }}>
    @foreach ($faqs as [$q, $a])
        <details class="faq__item">
            <summary class="faq__q">
                <span>{{ $q }}</span>
                <x-icon name="plus" size="20" class="faq__icon" />
            </summary>
            <div class="faq__a"><p>{{ $a }}</p></div>
        </details>
    @endforeach
</div>
@push('schema')
    @include('partials.schema.faq', ['faqs' => $faqs])
@endpush
