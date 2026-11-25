{{--
    Google tag (gtag.js) — IDs in config/site.php.
    Loaded only in production, after the page has finished loading,
    so it never slows down the first paint.
--}}
@if (app()->environment('production') && count(config('site.gtag_ids')))
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
@foreach (config('site.gtag_ids') as $id)
    gtag('config', @json($id));
@endforeach
    window.addEventListener('load', function () {
        setTimeout(function () {
            var s = document.createElement('script');
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + @json(config('site.gtag_ids')[0]);
            document.head.appendChild(s);
        }, 1500);
    });
</script>
@endif
