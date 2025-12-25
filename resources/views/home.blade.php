@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<section class="hero-gradient text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                Finden Sie die beste Autowerkstatt in Ihrer Nähe
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                Vergleichen Sie Werkstätten, TÜV-Stationen und Reifenhändler in ganz Deutschland
            </p>

            {{-- Search Bar --}}
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('locations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" placeholder="Stadt, PLZ oder Werkstattname..."
                           class="flex-1 px-6 py-4 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                           value="{{ request('search') }}">
                    <button type="submit" class="px-8 py-4 bg-indigo-800 hover:bg-indigo-900 text-white font-semibold rounded-lg transition duration-200">
                        Suchen
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Category Cards --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Was suchen Sie?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Workshop Card --}}
            <a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="card-hover bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900">Autowerkstätten</h3>
                    <p class="text-gray-600 mb-4">
                        Finden Sie qualifizierte Werkstätten für Reparaturen und Wartung
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge badge-workshop">{{ $workshopCount ?? 0 }} Werkstätten</span>
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- TUV Card --}}
            <a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="card-hover bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900">TÜV-Stationen</h3>
                    <p class="text-gray-600 mb-4">
                        Hauptuntersuchung und Abgasuntersuchung in Ihrer Nähe
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge badge-tuv">{{ $tuvCount ?? 0 }} Stationen</span>
                        <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Tire Dealer Card --}}
            <a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="card-hover bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-900">Reifenhändler</h3>
                    <p class="text-gray-600 mb-4">
                        Reifen kaufen und wechseln lassen bei Experten
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge badge-tire-dealer">{{ $tireDealerCount ?? 0 }} Händler</span>
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- Latest Blog Posts --}}
@if(isset($latestPosts) && $latestPosts->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Neueste Beiträge</h2>
            <a href="{{ route('posts.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                Alle Beiträge
                <svg class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <article class="card-hover bg-white rounded-xl shadow-lg overflow-hidden">
                @if($post->featured_image)
                <div class="aspect-video bg-gray-200">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-indigo-400 to-purple-500"></div>
                @endif
                <div class="p-6">
                    <time class="text-sm text-gray-500">{{ $post->published_at->format('d.m.Y') }}</time>
                    <h3 class="text-xl font-bold mt-2 mb-3 text-gray-900 line-clamp-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold inline-flex items-center">
                        Weiterlesen
                        <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-12 sm:px-12 sm:py-16 lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-0 lg:flex-1">
                    <h2 class="text-3xl font-bold text-white sm:text-4xl">
                        Bereit, Ihre Werkstatt zu finden?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg text-indigo-100">
                        Durchsuchen Sie tausende Werkstätten, TÜV-Stationen und Reifenhändler in ganz Deutschland. Finden Sie den perfekten Service für Ihr Fahrzeug.
                    </p>
                </div>
                <div class="mt-8 lg:mt-0 lg:ml-8">
                    <a href="{{ route('locations.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-gray-50 transition duration-200">
                        Jetzt suchen
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Warum Werkstatt.de?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Deutschlandweit</h3>
                <p class="text-gray-600">Tausende Werkstätten in ganz Deutschland</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Einfache Suche</h3>
                <p class="text-gray-600">Schnell und unkompliziert finden</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Aktuell</h3>
                <p class="text-gray-600">Immer auf dem neuesten Stand</p>
            </div>
        </div>
    </div>
</section>
@endsection
