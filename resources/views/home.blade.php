@extends('layouts.app')

@section('content')
{{-- BOLD INDUSTRIAL HERO - Asymmetric Layout --}}
<section class="hero-industrial relative overflow-hidden">
    <div class="hero-diagonal-bg"></div>

    {{-- Yellow Accent Blocks --}}
    <div class="accent-block accent-block-1"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-24 md:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            {{-- Left: Text Content --}}
            <div class="lg:col-span-7">
                {{-- Bold Number Badge --}}
                <div class="mb-8 reveal">
                    <span class="inline-flex items-center px-6 py-3 bg-yellow-500 text-charcoal-900 font-bold uppercase tracking-widest text-sm" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); font-family: var(--font-mono);">
                        <span class="w-2 h-2 bg-charcoal-900 mr-3" style="clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);"></span>
                        Deutschland's #1 Werkstatt-Finder
                    </span>
                </div>

                {{-- MEGA Headline --}}
                <h1 class="heading-mega text-white mb-8 reveal" style="animation-delay: 0.1s;">
                    FINDEN SIE DIE
                    <span class="block text-yellow-500 mt-2 stripe-yellow-vertical pl-8">
                        BESTE WERKSTATT
                    </span>
                    <span class="block mt-2">IN IHRER NÄHE</span>
                </h1>

                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-2xl leading-relaxed reveal" style="animation-delay: 0.2s;">
                    Vergleichen Sie <strong class="text-yellow-500">{{ number_format(($workshopCount ?? 0) + ($tuvCount ?? 0) + ($tireDealerCount ?? 0)) }}+ Standorte</strong> in ganz Deutschland. Schnell. Einfach. Präzise.
                </p>

                {{-- Industrial Search Bar --}}
                <div class="reveal" style="animation-delay: 0.3s;">
                    <form action="{{ route('locations.index') }}" method="GET" class="search-hero max-w-2xl">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative">
                                <input type="text"
                                       name="search"
                                       placeholder="Stadt, PLZ oder Werkstattname..."
                                       class="w-full px-6 py-5 bg-white text-charcoal-900 font-semibold text-lg focus:outline-none"
                                       style="font-family: var(--font-sans);"
                                       value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn-industrial px-10 py-5 whitespace-nowrap">
                                SUCHEN
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Technical Stats - JetBrains Mono --}}
                <div class="grid grid-cols-3 gap-6 mt-16 reveal" style="animation-delay: 0.4s;">
                    <div class="stat-industrial text-center">
                        <div class="number-badge mb-2">{{ number_format($workshopCount ?? 0) }}+</div>
                        <div class="text-xs uppercase tracking-wider text-charcoal-600 font-bold" style="font-family: var(--font-display);">Werkstätten</div>
                        <div class="card-accent"></div>
                    </div>
                    <div class="stat-industrial text-center">
                        <div class="number-badge mb-2">{{ number_format($tuvCount ?? 0) }}+</div>
                        <div class="text-xs uppercase tracking-wider text-charcoal-600 font-bold" style="font-family: var(--font-display);">TÜV-Stationen</div>
                        <div class="card-accent"></div>
                    </div>
                    <div class="stat-industrial text-center">
                        <div class="number-badge mb-2">{{ number_format($tireDealerCount ?? 0) }}+</div>
                        <div class="text-xs uppercase tracking-wider text-charcoal-600 font-bold" style="font-family: var(--font-display);">Reifenhändler</div>
                        <div class="card-accent"></div>
                    </div>
                </div>
            </div>

            {{-- Right: Visual Elements --}}
            <div class="lg:col-span-5 hidden lg:block reveal" style="animation-delay: 0.5s;">
                {{-- Industrial SVG Illustration - Wrench/Tools --}}
                <div class="relative">
                    <svg class="w-full h-auto text-yellow-500 opacity-20" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Large Industrial Wrench --}}
                        <path d="M245 100a16.67 16.67 0 0 0 0 23.33l26.67 26.67a16.67 16.67 0 0 0 23.33 0l62.83-62.83a100 100 0 0 1-132.33 132.33l-115.17 115.17a35.33 35.33 0 0 1-50-50L175.5 169.5a100 100 0 0 1 132.33-132.33L245 100z" stroke="currentColor" stroke-width="8" stroke-linecap="square" stroke-linejoin="miter"/>
                        {{-- Bolt detail --}}
                        <circle cx="120" cy="280" r="25" stroke="currentColor" stroke-width="6" fill="none"/>
                        <circle cx="120" cy="280" r="12" stroke="currentColor" stroke-width="4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES - Diagonal Sections, Not Cards --}}
<section class="diagonal-top bg-offwhite py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 reveal">
            <h2 class="heading-xl text-charcoal-900 mb-4">
                WAS SUCHEN SIE?
            </h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto"></div>
        </div>

        <div class="space-y-0">
            {{-- Category 01: Workshop --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 reveal">
                <div class="lg:col-span-2 flex items-center">
                    <div class="number-industrial">01</div>
                </div>
                <div class="lg:col-span-10">
                    <a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="block card-industrial p-10 group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-charcoal-900 flex items-center justify-center mr-6" style="clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);">
                                        <svg class="w-8 h-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="square" stroke-linejoin="miter" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="square" stroke-linejoin="miter" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="heading-lg text-charcoal-900 group-hover:text-yellow-500 transition-colors mb-2">
                                            AUTOWERKSTÄTTEN
                                        </h3>
                                        <div class="badge-industrial badge-workshop">{{ number_format($workshopCount ?? 0) }} Standorte</div>
                                    </div>
                                </div>
                                <p class="text-lg text-gray-700 leading-relaxed max-w-3xl">
                                    Professionelle Reparaturen, Wartung und Inspektionen. Qualifizierte Mechaniker für alle Fahrzeugtypen.
                                </p>
                            </div>
                            <div class="ml-8 hidden lg:block">
                                <svg class="w-12 h-12 text-yellow-500 transform group-hover:translate-x-3 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-accent"></div>
                    </a>
                </div>
            </div>

            {{-- Category 02: TUV --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 reveal">
                <div class="lg:col-span-2 flex items-center">
                    <div class="number-industrial">02</div>
                </div>
                <div class="lg:col-span-10">
                    <a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="block card-industrial p-10 group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-yellow-500 flex items-center justify-center mr-6" style="clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);">
                                        <svg class="w-8 h-8 text-charcoal-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="square" stroke-linejoin="miter" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="heading-lg text-charcoal-900 group-hover:text-yellow-500 transition-colors mb-2">
                                            TÜV-STATIONEN
                                        </h3>
                                        <div class="badge-industrial badge-tuv">{{ number_format($tuvCount ?? 0) }} Standorte</div>
                                    </div>
                                </div>
                                <p class="text-lg text-gray-700 leading-relaxed max-w-3xl">
                                    Hauptuntersuchung und Abgasuntersuchung. Zertifizierte Prüfstellen deutschlandweit verfügbar.
                                </p>
                            </div>
                            <div class="ml-8 hidden lg:block">
                                <svg class="w-12 h-12 text-yellow-500 transform group-hover:translate-x-3 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-accent"></div>
                    </a>
                </div>
            </div>

            {{-- Category 03: Tire Dealer --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 reveal">
                <div class="lg:col-span-2 flex items-center">
                    <div class="number-industrial">03</div>
                </div>
                <div class="lg:col-span-10">
                    <a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="block card-industrial p-10 group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-red-500 flex items-center justify-center mr-6" style="clip-path: polygon(8px 0, 100% 0, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0 100%, 0 8px);">
                                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="square" stroke-linejoin="miter" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="heading-lg text-charcoal-900 group-hover:text-red-500 transition-colors mb-2">
                                            REIFENHÄNDLER
                                        </h3>
                                        <div class="badge-industrial badge-tire-dealer">{{ number_format($tireDealerCount ?? 0) }} Standorte</div>
                                    </div>
                                </div>
                                <p class="text-lg text-gray-700 leading-relaxed max-w-3xl">
                                    Reifenkauf, Wechsel und Einlagerung. Sommer-, Winter- und Ganzjahresreifen für alle Fahrzeuge.
                                </p>
                            </div>
                            <div class="ml-8 hidden lg:block">
                                <svg class="w-12 h-12 text-red-500 transform group-hover:translate-x-3 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-accent"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES - Broken Grid Layout --}}
<section class="diagonal-both bg-charcoal-900 py-32">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 reveal">
            <h2 class="heading-xl text-white mb-4">
                WARUM WERKSTATT.DE?
            </h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto mb-6"></div>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                Deutsche Präzision trifft digitale Geschwindigkeit
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="card-broken bg-charcoal-800 p-10 border-yellow-500 reveal" style="animation-delay: 0.1s;">
                <div class="w-20 h-20 bg-yellow-500 flex items-center justify-center mb-8" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);">
                    <svg class="w-10 h-10 text-charcoal-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-yellow-500" style="font-family: var(--font-display);">DEUTSCHLANDWEIT</h3>
                <p class="text-gray-400 leading-relaxed text-lg">
                    Über {{ number_format(($workshopCount ?? 0) + ($tuvCount ?? 0) + ($tireDealerCount ?? 0)) }} geprüfte Standorte in allen Bundesländern. Überall verfügbar.
                </p>
            </div>

            <div class="card-broken bg-charcoal-800 p-10 border-yellow-500 reveal" style="animation-delay: 0.2s;">
                <div class="w-20 h-20 bg-yellow-500 flex items-center justify-center mb-8" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);">
                    <svg class="w-10 h-10 text-charcoal-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-yellow-500" style="font-family: var(--font-display);">BLITZSCHNELL</h3>
                <p class="text-gray-400 leading-relaxed text-lg">
                    Finden Sie in Sekunden die passende Werkstatt. Optimierte Performance für maximale Geschwindigkeit.
                </p>
            </div>

            <div class="card-broken bg-charcoal-800 p-10 border-yellow-500 reveal" style="animation-delay: 0.3s;">
                <div class="w-20 h-20 bg-yellow-500 flex items-center justify-center mb-8" style="clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);">
                    <svg class="w-10 h-10 text-charcoal-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-yellow-500" style="font-family: var(--font-display);">GEPRÜFT</h3>
                <p class="text-gray-400 leading-relaxed text-lg">
                    Alle Standorte werden sorgfältig verifiziert. Deutsche Qualitätsstandards garantiert.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- BLOG - Magazine Style if Posts Exist --}}
@if(isset($latestPosts) && $latestPosts->count() > 0)
<section class="diagonal-top bg-offwhite py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-16 reveal">
            <div>
                <h2 class="heading-xl text-charcoal-900 mb-4">
                    AKTUELLES
                </h2>
                <div class="w-24 h-1 bg-yellow-500"></div>
            </div>
            <a href="{{ route('posts.index') }}" class="btn-industrial-outline hidden md:inline-flex">
                ALLE BEITRÄGE
            </a>
        </div>

        {{-- Asymmetric Grid - Featured + 2 Small --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @foreach($latestPosts->take(3) as $index => $post)
                @if($index === 0)
                    {{-- Featured Large Post --}}
                    <article class="lg:col-span-7 card-industrial group reveal">
                        @if($post->featured_image)
                        <div class="h-96 overflow-hidden">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @else
                        <div class="h-96 bg-gradient-to-br from-yellow-500 to-red-500"></div>
                        @endif
                        <div class="p-8">
                            <time class="text-sm font-bold uppercase tracking-wider text-gray-500" style="font-family: var(--font-mono);">{{ $post->published_at->format('d.m.Y') }}</time>
                            <h3 class="text-3xl font-bold mt-4 mb-4 text-charcoal-900 group-hover:text-yellow-500 transition-colors" style="font-family: var(--font-display); line-height: 1.2;">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-700 mb-6 leading-relaxed text-lg">{{ $post->excerpt }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-charcoal-900 hover:text-yellow-500 font-bold uppercase tracking-wider text-sm transition-colors" style="font-family: var(--font-display);">
                                Weiterlesen
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                        <div class="card-accent"></div>
                    </article>
                @else
                    {{-- Smaller Posts --}}
                    <article class="lg:col-span-5 @if($index === 1) lg:row-span-1 @endif card-industrial group reveal" style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($post->featured_image)
                        <div class="h-56 overflow-hidden">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @else
                        <div class="h-56 bg-gradient-to-br from-charcoal-900 to-charcoal-800"></div>
                        @endif
                        <div class="p-6">
                            <time class="text-xs font-bold uppercase tracking-wider text-gray-500" style="font-family: var(--font-mono);">{{ $post->published_at->format('d.m.Y') }}</time>
                            <h3 class="text-xl font-bold mt-3 mb-3 text-charcoal-900 group-hover:text-yellow-500 transition-colors" style="font-family: var(--font-display); line-height: 1.2;">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-charcoal-900 hover:text-yellow-500 font-bold uppercase tracking-wider text-xs transition-colors" style="font-family: var(--font-display);">
                                Lesen
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                        <div class="card-accent"></div>
                    </article>
                @endif
            @endforeach
        </div>

        <div class="text-center mt-12 md:hidden">
            <a href="{{ route('posts.index') }}" class="btn-industrial-outline">
                ALLE BEITRÄGE
            </a>
        </div>
    </div>
</section>
@endif

{{-- BOLD CTA - Full Width --}}
<section class="bg-charcoal-900 py-24 relative overflow-hidden">
    {{-- Diagonal Yellow Accent --}}
    <div class="absolute top-0 left-0 w-full h-2 bg-yellow-500" style="transform: skewY(-1deg);"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl mx-auto text-center reveal">
            <h2 class="heading-hero text-white mb-8">
                BEREIT FÜR DIE
                <span class="block text-yellow-500 mt-2">BESTE WERKSTATT?</span>
            </h2>
            <p class="text-2xl text-gray-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                Durchsuchen Sie tausende Standorte. Kostenlos. Ohne Anmeldung. Sofort.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('locations.index') }}" class="btn-industrial text-lg px-12 py-6">
                    JETZT SUCHEN
                </a>
                <a href="{{ route('posts.index') }}" class="btn-industrial-outline text-lg px-12 py-6">
                    MEHR ERFAHREN
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom Diagonal Yellow Accent --}}
    <div class="absolute bottom-0 left-0 w-full h-2 bg-yellow-500" style="transform: skewY(1deg);"></div>
</section>
@endsection
