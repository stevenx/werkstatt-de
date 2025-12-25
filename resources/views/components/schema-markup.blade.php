@props(['type' => 'website', 'data' => []])

@php
    $schemaData = match($type) {
        'location' => [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? 'Professionelle KFZ-Dienstleistungen in ' . ($data['city'] ?? 'Deutschland'),
            'image' => $data['image'] ?? asset('images/default-location.jpg'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => ($data['street'] ?? '') . ' ' . ($data['house_number'] ?? ''),
                'addressLocality' => $data['city'] ?? '',
                'postalCode' => $data['postal_code'] ?? '',
                'addressRegion' => $data['state'] ?? '',
                'addressCountry' => 'DE',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $data['latitude'] ?? '',
                'longitude' => $data['longitude'] ?? '',
            ],
            'url' => $data['url'] ?? url()->current(),
            'telephone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'openingHours' => $data['opening_hours'] ?? null,
            'priceRange' => '$$',
        ],
        'post' => [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'description' => $data['excerpt'] ?? '',
            'image' => $data['featured_image'] ?? asset('images/default-post.jpg'),
            'datePublished' => isset($data['published_at']) ? $data['published_at']->toIso8601String() : '',
            'dateModified' => isset($data['updated_at']) ? $data['updated_at']->toIso8601String() : '',
            'author' => [
                '@type' => 'Person',
                'name' => $data['author_name'] ?? 'Werkstatt.de Team',
                'email' => $data['author_email'] ?? null,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $data['url'] ?? url()->current(),
            ],
        ],
        'breadcrumb' => [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($data['items'] ?? [])->map(function($item, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'] ?? null,
                ];
            })->filter(fn($item) => !empty($item['name']))->values()->toArray(),
        ],
        default => [],
    };

    // Remove null values
    $schemaData = array_filter($schemaData, fn($value) => $value !== null);
@endphp

@if(!empty($schemaData))
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif
