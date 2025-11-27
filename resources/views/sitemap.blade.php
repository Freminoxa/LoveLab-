
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    </url>

    <!-- About Page -->
    <url>
        <loc>{{ route('about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    </url>

    <!-- Events -->
    @foreach($events as $event)
        <url>
            <loc>{{ url('/events/' . $event->slug) }}</loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
            <lastmod>{{ $event->updated_at->format('Y-m-d') }}</lastmod>
        </url>
    @endforeach

</urlset>
