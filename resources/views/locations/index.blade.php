@extends('layouts.app')

@section('content')
{{-- BOLD INDUSTRIAL HEADER --}}
<section class="hero-industrial relative py-20 md:py-28 overflow-hidden">
    <div class="absolute inset-0 bg-charcoal-900"></div>

    {{-- Angular Yellow Accent Blocks --}}
    <div class="absolute top-20 right-10 w-48 h-48 border-4 border-yellow-500 opacity-20 transform rotate-12"></div>
    <div class="absolute bottom-10 left-10 w-32 h-32 bg-yellow-500 opacity-10"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-none" style="font-family: var(--font-display); letter-spacing: -0.03em;">
                @if(request('type') === 'workshop')
                    AUTOWERKSTÄTTEN
                @elseif(request('type') === 'tuv')
                    TÜV-STATIONEN
                @elseif(request('type') === 'tire_dealer')
                    REIFENHÄNDLER
                @else
                    ALLE STANDORTE
                @endif
            </h1>

            {{-- Yellow Accent Stripe --}}
            <div class="w-64 h-2 bg-yellow-500 mb-8 transform -skew-x-12"></div>

            {{-- Result Count --}}
            <div class="inline-block px-8 py-4 bg-yellow-500 border-2 border-white mb-8" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                <p class="text-charcoal-900 font-bold text-2xl" style="font-family: var(--font-mono);">
                    {{ number_format($locations->total()) }}
                    <span class="text-lg ml-2">{{ $locations->total() === 1 ? 'Standort' : 'Standorte' }}</span>
                </p>
            </div>

            {{-- Angular Breadcrumbs --}}
            <nav class="flex text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center gap-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-yellow-500 transition-colors font-semibold uppercase tracking-wider" style="font-family: var(--font-display);">Home</a>
                    </li>
                    <li>
                        <div class="w-6 h-0.5 bg-yellow-500 transform -skew-x-12"></div>
                    </li>
                    <li class="text-yellow-500 font-bold uppercase tracking-wider" style="font-family: var(--font-display);">Standorte</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Diagonal Bottom Edge --}}
    <div class="absolute bottom-0 left-0 w-full h-16 bg-offwhite transform origin-top-left -skew-y-2"></div>
</section>

{{-- Search and Filters Section --}}
<section class="py-12 bg-offwhite">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('location-search')
    </div>
</section>
@endsection
