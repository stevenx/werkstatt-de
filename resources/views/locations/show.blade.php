@extends('layouts.app')

@php
    $metaTitle = $location->name . ' - ' . $location->city . ' | werkstatt.de';
    $metaDescription = 'Informationen zu ' . $location->name . ' in ' . $location->postal_code . ' ' . $location->city . '. Adresse, Kontaktdaten und Öffnungszeiten.';
@endphp

@section('content')
{{-- BOLD INDUSTRIAL HERO --}}
<section class="relative bg-charcoal-900 pt-32 pb-20 overflow-hidden">
    {{-- Angular Yellow Stripe --}}
    <div class="absolute top-0 left-0 w-full h-2 bg-yellow-500"></div>

    {{-- Diagonal Background Accent --}}
    <div class="absolute top-0 right-0 w-1/2 h-full opacity-10">
        <div class="absolute top-20 right-10 w-64 h-64 border-4 border-yellow-500 transform rotate-12"></div>
        <div class="absolute bottom-10 right-32 w-32 h-32 bg-yellow-500 opacity-20"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Type Badge --}}
        @if($location->type === 'workshop')
            <div class="inline-block mb-6 px-6 py-3 bg-charcoal-800 border-2 border-yellow-500" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                <span class="text-yellow-500 font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-display);">⚙ Werkstatt</span>
            </div>
        @elseif($location->type === 'tuv')
            <div class="inline-block mb-6 px-6 py-3 bg-yellow-500" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                <span class="text-charcoal-900 font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-display);">✓ TÜV-Station</span>
            </div>
        @elseif($location->type === 'tire_dealer')
            <div class="inline-block mb-6 px-6 py-3 bg-red-500" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                <span class="text-white font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-display);">⚫ Reifenhändler</span>
            </div>
        @endif

        {{-- Large Location Name --}}
        <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-none" style="font-family: var(--font-display); letter-spacing: -0.03em;">
            {{ $location->name }}
        </h1>

        {{-- Yellow Accent Stripe Under Name --}}
        <div class="w-64 h-2 bg-yellow-500 mb-8 transform -skew-x-12"></div>

        {{-- City & Quick Info --}}
        <div class="flex flex-wrap items-center gap-6 text-lg">
            <div class="flex items-center text-gray-300">
                <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="square" stroke-linejoin="miter" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="font-semibold" style="font-family: var(--font-display);">{{ $location->city }}</span>
            </div>
            @if($location->postal_code)
            <div class="text-gray-400" style="font-family: var(--font-mono);">{{ $location->postal_code }}</div>
            @endif
        </div>
    </div>

    {{-- Diagonal Bottom Edge --}}
    <div class="absolute bottom-0 left-0 w-full h-16 bg-offwhite transform origin-top-left -skew-y-2"></div>
</section>

{{-- BREADCRUMBS --}}
<section class="bg-offwhite pt-8 pb-4">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-yellow-500 font-semibold transition-colors" style="font-family: var(--font-display);">
                Home
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('locations.index', ['type' => $location->type]) }}" class="text-gray-600 hover:text-yellow-500 font-semibold transition-colors" style="font-family: var(--font-display);">
                @if($location->type === 'workshop')
                    Werkstätten
                @elseif($location->type === 'tuv')
                    TÜV-Stationen
                @else
                    Reifenhändler
                @endif
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('locations.index', ['city' => $location->city]) }}" class="text-gray-600 hover:text-yellow-500 font-semibold transition-colors" style="font-family: var(--font-display);">
                {{ $location->city }}
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-charcoal-900 font-bold" style="font-family: var(--font-display);">{{ Str::limit($location->name, 40) }}</span>
        </nav>
    </div>
</section>

{{-- MAIN CONTENT - Asymmetric 70/30 Layout --}}
<section class="py-16 bg-offwhite">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-10 gap-8">

            {{-- MAIN COLUMN (70%) --}}
            <div class="lg:col-span-7 space-y-8">

                {{-- CONTACT CARD - Black with Yellow Borders --}}
                <div class="bg-charcoal-900 border-4 border-yellow-500 p-8" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-yellow-500 mr-4"></div>
                        <h2 class="text-3xl font-bold text-white" style="font-family: var(--font-display);">KONTAKT</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Address --}}
                        <div class="group">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-yellow-500 flex items-center justify-center flex-shrink-0" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                    <svg class="w-6 h-6 text-charcoal-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="square" stroke-linejoin="miter" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-yellow-500 font-bold mb-1 uppercase text-xs tracking-wider" style="font-family: var(--font-display);">Adresse</p>
                                    <p class="text-white leading-relaxed">
                                        @if($location->street)
                                            {{ $location->street }} {{ $location->house_number }}<br>
                                        @endif
                                        {{ $location->postal_code }} {{ $location->city }}
                                        @if($location->state)
                                            <br>{{ $location->state }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Phone --}}
                        @if($location->phone)
                        <div class="group">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 flex items-center justify-center flex-shrink-0 group-hover:bg-yellow-500 transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                    <svg class="w-6 h-6 text-yellow-500 group-hover:text-charcoal-900 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="square" stroke-linejoin="miter" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-yellow-500 font-bold mb-1 uppercase text-xs tracking-wider" style="font-family: var(--font-display);">Telefon</p>
                                    <a href="tel:{{ $location->phone }}" class="text-white hover:text-yellow-500 transition-colors font-semibold text-lg">{{ $location->phone }}</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Email --}}
                        @if($location->email)
                        <div class="group">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 flex items-center justify-center flex-shrink-0 group-hover:bg-yellow-500 transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                    <svg class="w-6 h-6 text-yellow-500 group-hover:text-charcoal-900 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="square" stroke-linejoin="miter" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-yellow-500 font-bold mb-1 uppercase text-xs tracking-wider" style="font-family: var(--font-display);">E-Mail</p>
                                    <a href="mailto:{{ $location->email }}" class="text-white hover:text-yellow-500 transition-colors break-all">{{ $location->email }}</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Website --}}
                        @if($location->website)
                        <div class="group">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 flex items-center justify-center flex-shrink-0 group-hover:bg-yellow-500 transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                    <svg class="w-6 h-6 text-yellow-500 group-hover:text-charcoal-900 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="square" stroke-linejoin="miter" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-yellow-500 font-bold mb-1 uppercase text-xs tracking-wider" style="font-family: var(--font-display);">Website</p>
                                    <a href="{{ $location->website }}" target="_blank" rel="noopener" class="text-white hover:text-yellow-500 transition-colors break-all">{{ parse_url($location->website, PHP_URL_HOST) }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- MAP SECTION - Full Width --}}
                @if($location->latitude && $location->longitude)
                <div class="bg-charcoal-900 border-4 border-yellow-500 overflow-hidden" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-1 h-8 bg-yellow-500 mr-4"></div>
                            <h2 class="text-3xl font-bold text-white" style="font-family: var(--font-display);">STANDORT</h2>
                        </div>
                        <div id="map" class="border-4 border-yellow-500" style="height: 450px; clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px); filter: grayscale(100%) contrast(120%) brightness(90%);"></div>
                    </div>
                </div>
                @endif

                {{-- DETAILS CARD --}}
                <div class="bg-charcoal-900 border-4 border-yellow-500 p-8" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-yellow-500 mr-4"></div>
                        <h2 class="text-3xl font-bold text-white" style="font-family: var(--font-display);">DETAILS</h2>
                    </div>

                    {{-- Opening Hours --}}
                    @if($location->opening_hours)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-yellow-500 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Öffnungszeiten</h3>
                        <div class="space-y-3">
                            @foreach($location->opening_hours as $day => $hours)
                            <div class="flex justify-between items-center p-3 bg-charcoal-800 border-l-4 border-yellow-500">
                                <span class="font-bold text-white" style="font-family: var(--font-display);">{{ ucfirst($day) }}</span>
                                <span class="text-gray-300 font-semibold" style="font-family: var(--font-mono);">{{ $hours }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Technical Info --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-charcoal-800 border-2 border-yellow-500 p-4" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                            <p class="text-yellow-500 text-xs font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Typ</p>
                            <p class="text-white font-bold" style="font-family: var(--font-mono);">
                                {{ $location->type === 'workshop' ? 'Werkstatt' : ($location->type === 'tuv' ? 'TÜV' : 'Reifenhändler') }}
                            </p>
                        </div>
                        <div class="bg-charcoal-800 border-2 border-yellow-500 p-4" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                            <p class="text-yellow-500 text-xs font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Aktualisiert</p>
                            <p class="text-white font-bold" style="font-family: var(--font-mono);">{{ $location->updated_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SIDEBAR (30%) --}}
            <div class="lg:col-span-3">
                <div class="sticky top-24 space-y-6">

                    {{-- QUICK ACTIONS --}}
                    <div class="bg-yellow-500 border-4 border-charcoal-900 p-6" style="clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);">
                        <h3 class="text-xl font-bold text-charcoal-900 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Aktionen</h3>

                        {{-- Route Planning --}}
                        @if($location->latitude && $location->longitude)
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $location->latitude }},{{ $location->longitude }}" target="_blank" rel="noopener" class="block w-full mb-3 px-6 py-4 bg-charcoal-900 text-yellow-500 font-bold text-center uppercase tracking-wider transition-all hover:bg-charcoal-800 hover:transform hover:-translate-y-1" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                            <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Route planen
                        </a>
                        @endif

                        {{-- Call --}}
                        @if($location->phone)
                        <a href="tel:{{ $location->phone }}" class="block w-full mb-3 px-6 py-4 bg-charcoal-900 text-yellow-500 font-bold text-center uppercase tracking-wider transition-all hover:bg-charcoal-800 hover:transform hover:-translate-y-1" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                            <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Anrufen
                        </a>
                        @endif

                        {{-- Website --}}
                        @if($location->website)
                        <a href="{{ $location->website }}" target="_blank" rel="noopener" class="block w-full px-6 py-4 bg-charcoal-900 text-yellow-500 font-bold text-center uppercase tracking-wider transition-all hover:bg-charcoal-800 hover:transform hover:-translate-y-1" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                            <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Website besuchen
                        </a>
                        @endif
                    </div>

                    {{-- STATS CARD --}}
                    <div class="bg-charcoal-900 border-4 border-yellow-500 p-6" style="clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);">
                        <h3 class="text-lg font-bold text-yellow-500 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Info</h3>

                        <div class="space-y-4">
                            <div class="border-b-2 border-charcoal-700 pb-3">
                                <p class="text-xs text-yellow-500 font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Kategorie</p>
                                <p class="text-lg font-bold text-white" style="font-family: var(--font-mono);">
                                    {{ $location->type === 'workshop' ? 'WERKSTATT' : ($location->type === 'tuv' ? 'TÜV-STATION' : 'REIFENHÄNDLER') }}
                                </p>
                            </div>
                            @if($location->state)
                            <div class="border-b-2 border-charcoal-700 pb-3">
                                <p class="text-xs text-yellow-500 font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Bundesland</p>
                                <p class="text-lg font-bold text-white" style="font-family: var(--font-mono);">{{ $location->state }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-xs text-yellow-500 font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Letzte Aktualisierung</p>
                                <p class="text-sm font-bold text-white" style="font-family: var(--font-mono);">{{ $location->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- DIAGONAL DIVIDER --}}
<div class="relative h-24 bg-charcoal-900 transform origin-top-left -skew-y-2"></div>

{{-- RELATED LOCATIONS --}}
@php
    $relatedLocations = \App\Models\Location::where('type', $location->type)
        ->where('city', $location->city)
        ->where('id', '!=', $location->id)
        ->limit(3)
        ->get();
@endphp

@if($relatedLocations->count() > 0)
<section class="py-20 bg-charcoal-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <div class="flex items-center mb-4">
                <div class="w-2 h-12 bg-yellow-500 mr-6"></div>
                <h2 class="text-4xl md:text-5xl font-bold text-white" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                    WEITERE IN {{ strtoupper($location->city) }}
                </h2>
            </div>
            <div class="w-48 h-1 bg-yellow-500 transform -skew-x-12 ml-20"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedLocations as $related)
            <a href="{{ route('locations.show', $related->id) }}" class="group bg-charcoal-800 border-2 border-charcoal-700 hover:border-yellow-500 p-6 transition-all hover:transform hover:-translate-y-2 card-broken" style="clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);">
                <div class="mb-4">
                    @if($related->type === 'workshop')
                        <span class="inline-block px-4 py-2 bg-charcoal-900 text-yellow-500 text-xs font-bold uppercase tracking-wider" style="font-family: var(--font-display); clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">Werkstatt</span>
                    @elseif($related->type === 'tuv')
                        <span class="inline-block px-4 py-2 bg-yellow-500 text-charcoal-900 text-xs font-bold uppercase tracking-wider" style="font-family: var(--font-display); clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">TÜV</span>
                    @else
                        <span class="inline-block px-4 py-2 bg-red-500 text-white text-xs font-bold uppercase tracking-wider" style="font-family: var(--font-display); clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">Reifen</span>
                    @endif
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-500 transition-colors" style="font-family: var(--font-display);">{{ $related->name }}</h3>
                <p class="text-gray-400">{{ $related->street }} {{ $related->house_number }}</p>
                <p class="text-gray-500 text-sm" style="font-family: var(--font-mono);">{{ $related->postal_code }} {{ $related->city }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($location->latitude && $location->longitude)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 15);

        // Add OpenStreetMap tile layer (Grayscale for industrial look)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" style="color: #FFD60A;">OpenStreetMap</a>',
            maxZoom: 19,
            className: 'map-tiles'
        }).addTo(map);

        // Custom Yellow Marker Icon
        const yellowIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="background: #FFD60A; width: 32px; height: 32px; clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); border: 3px solid #1a1a1a;"></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        // Add marker with custom icon
        const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], { icon: yellowIcon }).addTo(map);

        // Add popup to marker
        marker.bindPopup('<div style="font-family: var(--font-display); font-weight: bold;">{{ addslashes($location->name) }}</div><div style="font-family: var(--font-mono); font-size: 12px; color: #666;">{{ addslashes($location->formatted_address) }}</div>').openPopup();
    });
</script>
@endpush
@endif
@endsection
