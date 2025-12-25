<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>{{ $metaTitle ?? 'Werkstatt.de - Finden Sie die beste Autowerkstatt in Ihrer Nähe' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Entdecken Sie Autowerkstätten, TÜV-Stationen und Reifenhändler in ganz Deutschland. Vergleichen Sie Preise, Bewertungen und finden Sie den perfekten Service für Ihr Fahrzeug.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'Autowerkstatt, KFZ-Werkstatt, TÜV, Reifenhändler, Auto Service, Deutschland' }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $metaTitle ?? 'Werkstatt.de - Autowerkstätten finden' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Finden Sie die beste Autowerkstatt in Ihrer Nähe' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @isset($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    @endisset

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle ?? 'Werkstatt.de' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Finden Sie die beste Autowerkstatt in Ihrer Nähe' }}">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Additional Head Content --}}
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    {{-- Header --}}
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">Werkstatt.de</span>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('locations.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('locations.*') ? 'text-indigo-600' : '' }}">
                        Werkstätten
                    </a>
                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('posts.*') ? 'text-indigo-600' : '' }}">
                        Blog
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Navigation --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-indigo-600 bg-gray-50' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('locations.index') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('locations.*') ? 'text-indigo-600 bg-gray-50' : '' }}">
                        Werkstätten
                    </a>
                    <a href="{{ route('posts.index') }}" class="block text-gray-700 hover:text-indigo-600 hover:bg-gray-50 px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('posts.*') ? 'text-indigo-600 bg-gray-50' : '' }}">
                        Blog
                    </a>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Company Info --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Werkstatt.de</h3>
                    <p class="text-gray-400 text-sm">
                        Ihre Plattform für die Suche nach Autowerkstätten, TÜV-Stationen und Reifenhändlern in ganz Deutschland.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Home</a></li>
                        <li><a href="{{ route('locations.index') }}" class="text-gray-400 hover:text-white text-sm">Werkstätten</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-white text-sm">Blog</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="text-gray-400 hover:text-white text-sm">Werkstätten</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="text-gray-400 hover:text-white text-sm">TÜV-Stationen</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="text-gray-400 hover:text-white text-sm">Reifenhändler</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">Rechtliches</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Impressum</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">Datenschutz</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm">AGB</a></li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Werkstatt.de. Alle Rechte vorbehalten.
                </p>
            </div>
        </div>
    </footer>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    {{-- Additional Scripts --}}
    @stack('scripts')
</body>
</html>
