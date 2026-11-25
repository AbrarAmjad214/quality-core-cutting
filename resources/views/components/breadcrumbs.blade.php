{{-- Visible breadcrumbs. $items = [['Home', url('/')], ['Page', null]] — the last item is the current page. --}}
@props(['items'])
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <ol>
        @foreach ($items as [$label, $url])
            <li>
                @if ($loop->last)
                    <span aria-current="page">{{ $label }}</span>
                @else
                    <a href="{{ $url }}">{{ $label }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
