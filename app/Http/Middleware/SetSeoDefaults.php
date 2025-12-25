<?php

namespace App\Http\Middleware;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSeoDefaults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set default SEO meta tags
        SEOMeta::setTitle(config('app.name'));
        SEOMeta::setDescription('Finden Sie Werkstätten, TÜV-Stationen und Reifenhändler in Ihrer Nähe. Deutschlands umfassendster Standortfinder für Autowerkstätten und KFZ-Services.');
        SEOMeta::setCanonical(url()->current());
        SEOMeta::addKeyword([
            'Werkstatt',
            'Autowerkstatt',
            'TÜV',
            'Reifenhändler',
            'KFZ-Service',
            'Deutschland',
        ]);

        // Open Graph
        OpenGraph::setTitle(config('app.name'));
        OpenGraph::setDescription('Finden Sie Werkstätten, TÜV-Stationen und Reifenhändler in Ihrer Nähe.');
        OpenGraph::setUrl(url()->current());
        OpenGraph::setSiteName(config('app.name'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'de_DE');

        // Twitter Card
        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle(config('app.name'));
        TwitterCard::setDescription('Finden Sie Werkstätten, TÜV-Stationen und Reifenhändler in Ihrer Nähe.');
        TwitterCard::setUrl(url()->current());

        // JSON-LD (Schema.org)
        JsonLd::setTitle(config('app.name'));
        JsonLd::setDescription('Finden Sie Werkstätten, TÜV-Stationen und Reifenhändler in Ihrer Nähe.');
        JsonLd::setType('WebSite');
        JsonLd::addValue('url', config('app.url'));
        JsonLd::addValue('potentialAction', [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => config('app.url') . '/werkstatten?search={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ]);

        return $next($request);
    }
}
