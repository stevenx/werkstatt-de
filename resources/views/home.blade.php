@extends('layouts.app')

@section('content')
{{-- Premium Hero Section --}}
<section class="hero-premium relative py-24 md:py-32 overflow-hidden">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Trust Badge --}}
            <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-8 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Vertraut von tausenden Autofahrern in Deutschland
            </div>

            {{-- Main Headline --}}
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 animate-fade-in-up tracking-tight">
                Finden Sie die beste
                <span class="block bg-gradient-to-r from-yellow-200 to-orange-200 bg-clip-text text-transparent mt-2">
                    Autowerkstatt
                </span>
                in Ihrer Nähe
            </h1>

            <p class="text-xl md:text-2xl mb-12 text-indigo-100 max-w-2xl mx-auto animate-fade-in-up leading-relaxed" style="animation-delay: 0.1s;">
                Vergleichen Sie Werkstätten, TÜV-Stationen und Reifenhändler in ganz Deutschland. Schnell, einfach und transparent.
            </p>

            {{-- Premium Search Bar --}}
            <div class="max-w-3xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('locations.index') }}" method="GET" class="glass rounded-2xl p-2 shadow-2xl">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text"
                                   name="search"
                                   placeholder="Stadt, PLZ oder Werkstattname eingeben..."
                                   class="w-full pl-12 pr-4 py-4 bg-white rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg font-medium"
                                   value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn-premium btn-primary px-8 py-4 text-lg font-bold shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Suchen
                        </button>
                    </div>
                </form>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-3 gap-4 mt-8 text-white">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">{{ number_format($workshopCount ?? 0) }}+</div>
                        <div class="text-sm text-indigo-200">Werkstätten</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">{{ number_format($tuvCount ?? 0) }}+</div>
                        <div class="text-sm text-indigo-200">TÜV-Stationen</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">{{ number_format($tireDealerCount ?? 0) }}+</div>
                        <div class="text-sm text-indigo-200">Reifenhändler</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Premium Category Cards --}}
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-section">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
                Was suchen Sie?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Wählen Sie aus unseren spezialisierten Kategorien und finden Sie den perfekten Service
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10 max-w-6xl mx-auto">
            {{-- Workshop Card --}}
            <a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="card-premium group fade-in-section">
                <div class="p-8">
                    <div class="icon-container bg-gradient-to-br from-blue-100 to-blue-200 mb-6 group-hover:shadow-lg">
                        <svg class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">
                        Autowerkstätten
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Qualifizierte Werkstätten für professionelle Reparaturen, Wartung und Inspektionen
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge-premium badge-workshop">{{ number_format($workshopCount ?? 0) }} Werkstätten</span>
                        <svg class="w-6 h-6 text-blue-600 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- TUV Card --}}
            <a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="card-premium group fade-in-section" style="animation-delay: 0.1s;">
                <div class="p-8">
                    <div class="icon-container bg-gradient-to-br from-yellow-100 to-yellow-200 mb-6 group-hover:shadow-lg">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">
                        TÜV-Stationen
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Zertifizierte Prüfstellen für Hauptuntersuchung und Abgasuntersuchung in Ihrer Nähe
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge-premium badge-tuv">{{ number_format($tuvCount ?? 0) }} Stationen</span>
                        <svg class="w-6 h-6 text-yellow-600 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Tire Dealer Card --}}
            <a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="card-premium group fade-in-section" style="animation-delay: 0.2s;">
                <div class="p-8">
                    <div class="icon-container bg-gradient-to-br from-green-100 to-green-200 mb-6 group-hover:shadow-lg">
                        <svg class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">
                        Reifenhändler
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Professionelle Reifenhändler für Kauf, Wechsel und Einlagerung aller Reifentypen
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="badge-premium badge-tire-dealer">{{ number_format($tireDealerCount ?? 0) }} Händler</span>
                        <svg class="w-6 h-6 text-green-600 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-24 gradient-mesh">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-section">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
                Warum Werkstatt.de?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Ihre Vorteile auf einen Blick
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="text-center fade-in-section">
                <div class="icon-container bg-gradient-to-br from-indigo-100 to-indigo-200 mx-auto mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900">Deutschlandweit</h3>
                <p class="text-gray-600 leading-relaxed">
                    Über {{ number_format(($workshopCount ?? 0) + ($tuvCount ?? 0) + ($tireDealerCount ?? 0)) }} geprüfte Standorte in ganz Deutschland
                </p>
            </div>

            <div class="text-center fade-in-section" style="animation-delay: 0.1s;">
                <div class="icon-container bg-gradient-to-br from-indigo-100 to-indigo-200 mx-auto mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900">Blitzschnell</h3>
                <p class="text-gray-600 leading-relaxed">
                    Finden Sie in Sekunden die passende Werkstatt in Ihrer Nähe
                </p>
            </div>

            <div class="text-center fade-in-section" style="animation-delay: 0.2s;">
                <div class="icon-container bg-gradient-to-br from-indigo-100 to-indigo-200 mx-auto mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900">Vertrauenswürdig</h3>
                <p class="text-gray-600 leading-relaxed">
                    Alle Standorte werden sorgfältig geprüft und verifiziert
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Latest Blog Posts --}}
@if(isset($latestPosts) && $latestPosts->count() > 0)
<section class="py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 fade-in-section">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
                    Neueste Beiträge
                </h2>
                <p class="text-xl text-gray-600">
                    Tipps und Wissenswertes rund um Ihr Fahrzeug
                </p>
            </div>
            <a href="{{ route('posts.index') }}" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl">
                Alle Beiträge
                <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $index => $post)
            <article class="card-premium group fade-in-section" style="animation-delay: {{ $index * 0.1 }}s;">
                @if($post->featured_image)
                <div class="aspect-video overflow-hidden rounded-t-xl">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 image-placeholder rounded-t-xl"></div>
                @endif
                <div class="p-6">
                    <time class="text-sm font-medium text-gray-500">{{ $post->published_at->format('d.m.Y') }}</time>
                    <h3 class="text-xl font-bold mt-2 mb-3 text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-2 leading-relaxed text-sm">{{ $post->excerpt }}</p>
                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                        Weiterlesen
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Premium CTA Section --}}
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600"></div>
    <div class="absolute inset-0 bg-black opacity-10"></div>

    {{-- Decorative Elements --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-float"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-overlay filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center fade-in-section">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight">
                Bereit, Ihre Werkstatt zu finden?
            </h2>
            <p class="text-xl md:text-2xl text-indigo-100 mb-12 max-w-2xl mx-auto leading-relaxed">
                Durchsuchen Sie tausende Werkstätten, TÜV-Stationen und Reifenhändler in ganz Deutschland. Kostenlos und ohne Anmeldung.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('locations.index') }}" class="btn-premium inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-2xl hover:shadow-3xl text-lg">
                    <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Jetzt suchen
                </a>
                <a href="{{ route('posts.index') }}" class="btn-premium inline-flex items-center justify-center px-10 py-5 bg-transparent text-white font-bold rounded-xl hover:bg-white/10 transition-all border-2 border-white text-lg">
                    Mehr erfahren
                    <svg class="w-6 h-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
