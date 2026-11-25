{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach ($pages as $p)
    <url>
        <loc>{{ $p['url'] }}</loc>
        <lastmod>{{ $p['lastmod'] }}</lastmod>
        <priority>{{ $p['priority'] }}</priority>
@foreach ($p['images'] as $i)
        <image:image>
            <image:loc>{{ $i['loc'] }}</image:loc>
            <image:title>{{ $i['title'] }}</image:title>
        </image:image>
@endforeach
    </url>
@endforeach
</urlset>
