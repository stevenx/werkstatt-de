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

    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
    {{-- Premium Header --}}
    <header class="nav-premium sticky top-0 z-50" id="main-nav">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="relative">
                            <svg class="h-10 w-10 text-indigo-600 transition-transform group-hover:scale-110 group-hover:rotate-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-500"></div>
                        </div>
                        <span class="ml-3 text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Werkstatt.de</span>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex md:items-center md:space-x-1">
                    <a href="{{ route('home') }}" class="relative px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium text-sm transition-colors group {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">
                        Home
                        @if(request()->routeIs('home'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600"></span>
                        @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 transition-all group-hover:w-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('locations.index') }}" class="relative px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium text-sm transition-colors group {{ request()->routeIs('locations.*') ? 'text-indigo-600' : '' }}">
                        Werkstätten
                        @if(request()->routeIs('locations.*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600"></span>
                        @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 transition-all group-hover:w-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('posts.index') }}" class="relative px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium text-sm transition-colors group {{ request()->routeIs('posts.*') ? 'text-indigo-600' : '' }}">
                        Blog
                        @if(request()->routeIs('posts.*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600"></span>
                        @else
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 transition-all group-hover:w-full"></span>
                        @endif
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600 transition-colors">
                        <svg class="h-7 w-7" id="menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-7 w-7 hidden" id="close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Navigation --}}
            <div id="mobile-menu" class="hidden md:hidden pb-6 animate-fade-in">
                <div class="space-y-2 pt-2">
                    <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg font-medium transition-all {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('locations.index') }}" class="block px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg font-medium transition-all {{ request()->routeIs('locations.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        Werkstätten
                    </a>
                    <a href="{{ route('posts.index') }}" class="block px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg font-medium transition-all {{ request()->routeIs('posts.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
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

    {{-- Premium Footer --}}
    <footer class="footer-premium mt-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                {{-- Company Info --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center mb-6">
                        <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-white">Werkstatt.de</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Ihre Premium-Plattform für die Suche nach Autowerkstätten, TÜV-Stationen und Reifenhändlern in ganz Deutschland.
                    </p>
                    <div class="flex space-x-4">
                        {{-- Social Media Icons --}}
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-white text-lg font-semibold mb-6">Schnellzugriff</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Home</a></li>
                        <li><a href="{{ route('locations.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Alle Werkstätten</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Blog & Ratgeber</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div>
                    <h3 class="text-white text-lg font-semibold mb-6">Kategorien</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Autowerkstätten</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">TÜV-Stationen</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Reifenhändler</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div>
                    <h3 class="text-white text-lg font-semibold mb-6">Rechtliches</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Impressum</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Datenschutz</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">AGB</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors hover:translate-x-1 inline-block">Cookie-Richtlinie</a></li>
                    </ul>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Werkstatt.de. Alle Rechte vorbehalten.
                    </p>
                    <p class="text-gray-500 text-xs">
                        Made with care in Germany
                    </p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- Premium Scripts --}}
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Navbar scroll effect
        let lastScroll = 0;
        const nav = document.getElementById('main-nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-in-section').forEach(el => observer.observe(el));
        });
    </script>

    {{-- Additional Scripts --}}
    @stack('scripts')
</body>
</html>
