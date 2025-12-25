@extends('layouts.app')

@php
    $metaTitle = 'Blog - Autowerkstatt Tipps & News | werkstatt.de';
    $metaDescription = 'Lesen Sie aktuelle Artikel rund um Autowerkstätten, Fahrzeugwartung, TÜV und Auto-Reparaturen. Tipps und Tricks für Autobesitzer.';
    $featuredPost = $posts->first();
@endphp

@section('content')

@if($featuredPost)
{{-- FEATURED POST HERO --}}
<section class="relative bg-charcoal-900 overflow-hidden">
    <div class="relative h-[80vh] min-h-[600px]">
        @if($featuredPost->featured_image)
        <img src="{{ Storage::url($featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif

        {{-- Yellow Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-charcoal-900/95 via-charcoal-900/80 to-yellow-500/20"></div>

        {{-- Angular Clip-Path Effect --}}
        <div class="absolute bottom-0 left-0 w-full h-32 bg-offwhite transform origin-top-left -skew-y-2"></div>

        {{-- Content Over Image --}}
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-4xl">
                    {{-- Featured Badge --}}
                    <div class="inline-block mb-6 px-8 py-4 bg-yellow-500 border-2 border-white" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                        <span class="text-charcoal-900 font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-display);">★ Featured Article</span>
                    </div>

                    {{-- Large Headline --}}
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-none" style="font-family: var(--font-display); letter-spacing: -0.03em;">
                        {{ $featuredPost->title }}
                    </h1>

                    {{-- Yellow Accent Stripe --}}
                    <div class="w-64 h-2 bg-yellow-500 mb-8 transform -skew-x-12"></div>

                    {{-- Excerpt --}}
                    @if($featuredPost->excerpt)
                    <p class="text-xl text-gray-300 mb-8 max-w-2xl leading-relaxed">
                        {{ Str::limit($featuredPost->excerpt, 150) }}
                    </p>
                    @endif

                    {{-- CTA Button --}}
                    <a href="{{ route('posts.show', $featuredPost->slug) }}" class="inline-block px-12 py-5 bg-yellow-500 text-charcoal-900 font-bold uppercase tracking-wider transition-all hover:bg-white hover:transform hover:-translate-y-1 hover:shadow-lg" style="font-family: var(--font-display); clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                        Artikel lesen
                        <svg class="w-5 h-5 inline-block ml-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@else
{{-- STANDARD HEADER IF NO POSTS --}}
<section class="hero-industrial relative py-20 md:py-28 overflow-hidden">
    <div class="absolute inset-0 bg-charcoal-900"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-none" style="font-family: var(--font-display); letter-spacing: -0.03em;">
                BLOG & RATGEBER
            </h1>
            <div class="w-64 h-2 bg-yellow-500 mb-8 transform -skew-x-12"></div>
            <p class="text-xl text-gray-300">
                Tipps, News und Ratgeber rund um Autowerkstätten und Fahrzeugpflege
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 w-full h-16 bg-offwhite transform origin-top-left -skew-y-2"></div>
</section>
@endif

{{-- BLOG POSTS GRID --}}
<section class="py-16 bg-offwhite">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        @if($posts->count() > 0)
            {{-- ASYMMETRIC GRID: First 3 Posts (1 Large + 2 Small) --}}
            @if($posts->count() >= 3)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                {{-- LARGE POST (2/3 Width) --}}
                @php $largePost = $posts->skip(1)->first(); @endphp
                @if($largePost)
                <a href="{{ route('posts.show', $largePost->slug) }}" class="group lg:col-span-2 bg-white border-4 border-charcoal-900 overflow-hidden hover:transform hover:-translate-y-2 transition-all card-broken" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                    @if($largePost->featured_image)
                    <div class="aspect-[16/9] bg-gray-200 overflow-hidden">
                        <img src="{{ Storage::url($largePost->featured_image) }}" alt="{{ $largePost->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    @else
                    <div class="aspect-[16/9] bg-gradient-to-br from-yellow-500 to-red-500"></div>
                    @endif

                    <div class="p-8">
                        <time class="inline-block mb-3 px-4 py-2 bg-charcoal-900 text-yellow-500 text-xs font-bold uppercase tracking-wider" style="font-family: var(--font-mono); clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                            {{ $largePost->published_at->format('d. M Y') }}
                        </time>

                        <h2 class="text-3xl font-bold text-charcoal-900 mb-4 group-hover:text-yellow-500 transition-colors line-clamp-2" style="font-family: var(--font-display);">
                            {{ $largePost->title }}
                        </h2>

                        @if($largePost->excerpt)
                        <p class="text-gray-600 text-lg line-clamp-3 mb-6">{{ $largePost->excerpt }}</p>
                        @endif

                        <div class="flex items-center text-yellow-500 font-bold uppercase text-sm tracking-wider" style="font-family: var(--font-display);">
                            Weiterlesen
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>

                    {{-- Yellow Hover Border --}}
                    <div class="absolute bottom-0 left-0 w-0 h-2 bg-yellow-500 group-hover:w-full transition-all duration-500"></div>
                </a>
                @endif

                {{-- SMALL POSTS (1/3 Width Each) --}}
                <div class="space-y-8">
                    @foreach($posts->skip(2)->take(2) as $smallPost)
                    <a href="{{ route('posts.show', $smallPost->slug) }}" class="group block bg-white border-4 border-charcoal-900 overflow-hidden hover:border-yellow-500 hover:transform hover:-translate-y-2 transition-all" style="clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);">
                        @if($smallPost->featured_image)
                        <div class="aspect-video bg-gray-200 overflow-hidden">
                            <img src="{{ Storage::url($smallPost->featured_image) }}" alt="{{ $smallPost->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @else
                        <div class="aspect-video bg-gradient-to-br from-charcoal-800 to-charcoal-900"></div>
                        @endif

                        <div class="p-6">
                            <time class="text-yellow-500 text-xs font-bold uppercase tracking-wider mb-2 block" style="font-family: var(--font-mono);">
                                {{ $smallPost->published_at->format('d. M Y') }}
                            </time>

                            <h3 class="text-xl font-bold text-charcoal-900 mb-2 group-hover:text-yellow-500 transition-colors line-clamp-2" style="font-family: var(--font-display);">
                                {{ $smallPost->title }}
                            </h3>

                            @if($smallPost->excerpt)
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $smallPost->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- DIAGONAL DIVIDER --}}
            <div class="relative h-2 bg-yellow-500 transform -skew-x-12 my-16"></div>

            {{-- REGULAR GRID: Remaining Posts --}}
            @if($posts->count() > 4)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts->skip(4) as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="group bg-white border-4 border-charcoal-900 overflow-hidden hover:border-yellow-500 hover:transform hover:-translate-y-2 transition-all card-broken" style="clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);">
                    @if($post->featured_image)
                    <div class="aspect-video bg-gray-200 overflow-hidden">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-charcoal-800 to-yellow-500/20"></div>
                    @endif

                    <div class="p-6">
                        <time class="inline-block mb-3 px-3 py-1 bg-charcoal-900 text-yellow-500 text-xs font-bold uppercase tracking-wider" style="font-family: var(--font-mono); clip-path: polygon(4px 0, 100% 0, calc(100% - 4px) 100%, 0 100%);">
                            {{ $post->published_at->format('d. M Y') }}
                        </time>

                        <h3 class="text-xl font-bold text-charcoal-900 mb-3 group-hover:text-yellow-500 transition-colors line-clamp-2" style="font-family: var(--font-display);">
                            {{ $post->title }}
                        </h3>

                        @if($post->excerpt)
                        <p class="text-gray-600 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                        @endif

                        <div class="flex items-center text-yellow-500 font-bold uppercase text-sm tracking-wider" style="font-family: var(--font-display);">
                            Lesen
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $posts->links() }}
            </div>

        @else
            {{-- No Posts State --}}
            <div class="bg-white border-4 border-charcoal-900 p-16 text-center" style="clip-path: polygon(32px 0, 100% 0, 100% calc(100% - 32px), calc(100% - 32px) 100%, 0 100%, 0 32px);">
                <div class="w-24 h-24 bg-charcoal-900 mx-auto mb-6 flex items-center justify-center" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-3xl font-bold mb-4 text-charcoal-900" style="font-family: var(--font-display);">KEINE BEITRÄGE GEFUNDEN</h3>
                <p class="text-gray-600 text-lg">Schauen Sie später wieder vorbei für neue Artikel.</p>
            </div>
        @endif

    </div>
</section>

{{-- CTA SECTION --}}
@if($posts->count() > 0)
<section class="relative py-20 bg-charcoal-900 overflow-hidden">
    {{-- Angular Accents --}}
    <div class="absolute top-10 right-10 w-64 h-64 border-4 border-yellow-500 opacity-10 transform rotate-12"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block mb-6 px-8 py-3 bg-yellow-500" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                <span class="text-charcoal-900 font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-display);">Werkstatt finden</span>
            </div>

            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                BEREIT FÜR DEN SERVICE?
            </h2>

            <div class="w-48 h-1 bg-yellow-500 transform -skew-x-12 mx-auto mb-8"></div>

            <p class="text-xl text-gray-300 mb-10">
                Finden Sie die perfekte Autowerkstatt in Ihrer Nähe
            </p>

            <a href="{{ route('locations.index') }}" class="inline-block px-12 py-5 bg-yellow-500 text-charcoal-900 font-bold uppercase tracking-wider transition-all hover:bg-white hover:transform hover:-translate-y-1 hover:shadow-lg" style="font-family: var(--font-display); clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                Werkstätten durchsuchen
                <svg class="w-5 h-5 inline-block ml-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="square" stroke-linejoin="miter" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

@endsection
