@extends('layouts.app')

@section('content')
{{-- Premium Page Header --}}
<section class="hero-premium relative py-16 md:py-20 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500"></div>
    <div class="absolute inset-0 opacity-20 bg-black"></div>

    {{-- Animated background --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-float"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 tracking-tight animate-fade-in-up">
                @if(request('type') === 'workshop')
                    Autowerkstätten finden
                @elseif(request('type') === 'tuv')
                    TÜV-Stationen finden
                @elseif(request('type') === 'tire_dealer')
                    Reifenhändler finden
                @else
                    Alle Standorte entdecken
                @endif
            </h1>
            <p class="text-xl text-indigo-100 mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                {{ number_format($locations->total()) }} {{ $locations->total() === 1 ? 'Ergebnis' : 'Ergebnisse' }} in ganz Deutschland
            </p>

            {{-- Breadcrumbs --}}
            <nav class="flex text-sm text-white/80 animate-fade-in-up" style="animation-delay: 0.2s;" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    </li>
                    <li><span class="text-white/50">/</span></li>
                    <li class="text-white font-medium">Standorte</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Search and Filters Section --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('location-search')
    </div>
</section>
@endsection
