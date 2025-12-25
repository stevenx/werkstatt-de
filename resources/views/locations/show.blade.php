@extends('layouts.app')

@php
    $metaTitle = $location->name . ' - ' . $location->city . ' | Werkstatt.de';
    $metaDescription = 'Informationen zu ' . $location->name . ' in ' . $location->postal_code . ' ' . $location->city . '. Adresse, Kontaktdaten und Öffnungszeiten.';
@endphp

@section('content')
{{-- Breadcrumbs --}}
<div class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">Home</a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li>
                    <a href="{{ route('locations.index') }}" class="text-gray-500 hover:text-indigo-600">Standorte</a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium">{{ $location->name }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Content --}}
<section class="py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column - Details --}}
            <div class="lg:col-span-2">
                {{-- Header --}}
                <div class="mb-6">
                    @if($location->type === 'workshop')
                        <span class="badge badge-workshop mb-3 inline-block">Werkstatt</span>
                    @elseif($location->type === 'tuv')
                        <span class="badge badge-tuv mb-3 inline-block">TÜV</span>
                    @elseif($location->type === 'tire_dealer')
                        <span class="badge badge-tire-dealer mb-3 inline-block">Reifenhändler</span>
                    @endif

                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $location->name }}</h1>
                    <p class="text-xl text-gray-600">{{ $location->city }}</p>
                </div>

                {{-- Info Card --}}
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Kontaktinformationen</h2>

                    {{-- Address --}}
                    <div class="mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Adresse</p>
                                <p class="text-gray-600">
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
                    <div class="mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Telefon</p>
                                <a href="tel:{{ $location->phone }}" class="text-indigo-600 hover:text-indigo-800">{{ $location->phone }}</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Email --}}
                    @if($location->email)
                    <div class="mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">E-Mail</p>
                                <a href="mailto:{{ $location->email }}" class="text-indigo-600 hover:text-indigo-800">{{ $location->email }}</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Website --}}
                    @if($location->website)
                    <div class="mb-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Website</p>
                                <a href="{{ $location->website }}" target="_blank" rel="noopener" class="text-indigo-600 hover:text-indigo-800 break-all">{{ $location->website }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Opening Hours --}}
                @if($location->opening_hours)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Öffnungszeiten</h2>
                    <div class="space-y-2">
                        @foreach($location->opening_hours as $day => $hours)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">{{ ucfirst($day) }}:</span>
                            <span class="text-gray-600">{{ $hours }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Map --}}
                @if($location->latitude && $location->longitude)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Standort auf Karte</h2>
                    <div id="map" class="leaflet-container rounded-lg"></div>
                </div>
                @endif
            </div>

            {{-- Right Column - Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-20">
                    <h3 class="text-xl font-bold mb-4 text-gray-900">Schnellaktionen</h3>

                    @if($location->phone)
                    <a href="tel:{{ $location->phone }}" class="block w-full mb-3 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-center transition duration-200">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Jetzt anrufen
                    </a>
                    @endif

                    @if($location->website)
                    <a href="{{ $location->website }}" target="_blank" rel="noopener" class="block w-full mb-3 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg text-center transition duration-200">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Website besuchen
                    </a>
                    @endif

                    @if($location->latitude && $location->longitude)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $location->latitude }},{{ $location->longitude }}" target="_blank" rel="noopener" class="block w-full px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg text-center transition duration-200">
                        <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Route planen
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($location->latitude && $location->longitude)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 15);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Add marker
        const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}]).addTo(map);

        // Add popup to marker
        marker.bindPopup('<strong>{{ addslashes($location->name) }}</strong><br>{{ addslashes($location->formatted_address) }}').openPopup();
    });
</script>
@endpush
@endif
@endsection
