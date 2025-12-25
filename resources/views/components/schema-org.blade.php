@props(['type' => 'Organization', 'data' => []])

@php
$schemas = [
    'Organization' => [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Werkstatt.de',
        'url' => url('/'),
        'logo' => asset('favicon.svg'),
        'description' => 'Finden Sie die beste Autowerkstatt, TÜV-Station oder Reifenhändler in Ihrer Nähe',
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'areaServed' => 'DE',
            'availableLanguage' => 'German'
        ]
    ],
    'WebSite' => [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Werkstatt.de',
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => url('/werkstatten') . '?search={search_term_string}'
            ],
            'query-input' => 'required name=search_term_string'
        ]
    ],
    'LocalBusiness' => array_merge([
        '@context' => 'https://schema.org',
        '@type' => 'AutoRepair',
    ], $data),
    'Article' => array_merge([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
    ], $data),
    'BreadcrumbList' => array_merge([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
    ], $data),
];

$schema = $schemas[$type] ?? [];
@endphp

@if(!empty($schema))
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
