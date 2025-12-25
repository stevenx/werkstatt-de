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
<body class="antialiased">
    {{-- BOLD INDUSTRIAL HEADER --}}
    <header class="nav-industrial sticky top-0 z-50" id="main-nav">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                {{-- Logo - Bold & Industrial --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="relative">
                            {{-- Wrench Icon - Industrial Workshop Style --}}
                            <svg class="h-12 w-12 text-yellow-500 transition-all duration-300 group-hover:rotate-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                {{-- Wrench handle --}}
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <span class="text-3xl font-bold text-white" style="font-family: var(--font-display); letter-spacing: -0.02em;">werkstatt<span class="text-yellow-500">.de</span></span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('locations.index') }}" class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                        Werkstätten
                    </a>
                    <a href="{{ route('posts.index') }}" class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        Blog
                    </a>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-white hover:text-yellow-500 focus:outline-none focus:text-yellow-500 transition-colors">
                        <svg class="h-8 w-8" id="menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-8 w-8 hidden" id="close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Navigation - Full Screen Takeover --}}
            <div id="mobile-menu" class="hidden md:hidden fixed inset-0 bg-charcoal-900 z-50 animate-slide-up" style="top: 0; left: 0; right: 0; bottom: 0;">
                <div class="flex flex-col h-full">
                    {{-- Close Button --}}
                    <div class="flex justify-end p-6">
                        <button type="button" id="mobile-menu-close" class="text-white hover:text-yellow-500 transition-colors">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Menu Items - Large & Bold --}}
                    <div class="flex-1 flex flex-col justify-center px-8 space-y-8">
                        <a href="{{ route('home') }}" class="text-5xl font-bold text-white hover:text-yellow-500 transition-colors {{ request()->routeIs('home') ? 'text-yellow-500' : '' }}" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                            HOME
                        </a>
                        <a href="{{ route('locations.index') }}" class="text-5xl font-bold text-white hover:text-yellow-500 transition-colors {{ request()->routeIs('locations.*') ? 'text-yellow-500' : '' }}" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                            WERKSTÄTTEN
                        </a>
                        <a href="{{ route('posts.index') }}" class="text-5xl font-bold text-white hover:text-yellow-500 transition-colors {{ request()->routeIs('posts.*') ? 'text-yellow-500' : '' }}" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                            BLOG
                        </a>
                    </div>

                    {{-- Yellow Accent Stripe --}}
                    <div class="h-2 bg-yellow-500"></div>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- INDUSTRIAL FOOTER --}}
    <footer class="footer-industrial mt-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
                {{-- Company Info --}}
                <div class="lg:col-span-5">
                    <div class="flex items-center mb-8">
                        <svg class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-3 text-2xl font-bold text-white" style="font-family: var(--font-display);">werkstatt<span class="text-yellow-500">.de</span></span>
                    </div>
                    <p class="text-base leading-relaxed mb-8" style="color: #9ca3af;">
                        Deutschlands führende Plattform für Autowerkstätten, TÜV-Stationen und Reifenhändler. Präzision, Geschwindigkeit, Zuverlässigkeit.
                    </p>
                    <div class="flex space-x-4">
                        {{-- Social Media - Angular Buttons --}}
                        <a href="#" class="w-12 h-12 bg-charcoal-800 hover:bg-yellow-500 text-white hover:text-charcoal-900 flex items-center justify-center transition-all border-2 border-charcoal-800 hover:border-yellow-500" style="clip-path: polygon(4px 0, 100% 0, 100% calc(100% - 4px), calc(100% - 4px) 100%, 0 100%, 0 4px);">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-charcoal-800 hover:bg-yellow-500 text-white hover:text-charcoal-900 flex items-center justify-center transition-all border-2 border-charcoal-800 hover:border-yellow-500" style="clip-path: polygon(4px 0, 100% 0, 100% calc(100% - 4px), calc(100% - 4px) 100%, 0 100%, 0 4px);">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-charcoal-800 hover:bg-yellow-500 text-white hover:text-charcoal-900 flex items-center justify-center transition-all border-2 border-charcoal-800 hover:border-yellow-500" style="clip-path: polygon(4px 0, 100% 0, 100% calc(100% - 4px), calc(100% - 4px) 100%, 0 100%, 0 4px);">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="lg:col-span-2">
                    <h3 class="text-white text-sm font-bold mb-6 uppercase tracking-wider" style="font-family: var(--font-display);">Navigation</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                        <li><a href="{{ route('locations.index') }}" class="footer-link">Alle Werkstätten</a></li>
                        <li><a href="{{ route('posts.index') }}" class="footer-link">Blog & Ratgeber</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div class="lg:col-span-2">
                    <h3 class="text-white text-sm font-bold mb-6 uppercase tracking-wider" style="font-family: var(--font-display);">Kategorien</h3>
                    <ul class="space-y-4">
                        <li><a href="{{ route('locations.index', ['type' => 'workshop']) }}" class="footer-link">Autowerkstätten</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tuv']) }}" class="footer-link">TÜV-Stationen</a></li>
                        <li><a href="{{ route('locations.index', ['type' => 'tire_dealer']) }}" class="footer-link">Reifenhändler</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div class="lg:col-span-3">
                    <h3 class="text-white text-sm font-bold mb-6 uppercase tracking-wider" style="font-family: var(--font-display);">Rechtliches</h3>
                    <ul class="space-y-4">
                        <li><a href="#" class="footer-link">Impressum</a></li>
                        <li><a href="#" class="footer-link">Datenschutz</a></li>
                        <li><a href="#" class="footer-link">AGB</a></li>
                        <li><a href="#" class="footer-link">Cookie-Richtlinie</a></li>
                    </ul>
                </div>
            </div>

            {{-- Copyright - Industrial Divider --}}
            <div class="relative">
                <div class="absolute top-0 left-0 right-0 h-px bg-yellow-500"></div>
                <div class="pt-10 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-sm" style="color: #6c757d; font-family: var(--font-mono);">
                        © {{ date('Y') }} WERKSTATT.DE — ALLE RECHTE VORBEHALTEN
                    </p>
                    <p class="text-xs uppercase tracking-widest" style="color: #495057; font-family: var(--font-mono); font-weight: 700;">
                        Made with Precision in Germany
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

    {{-- Industrial Scripts --}}
    <script>
        // Mobile Menu Toggle - Full Screen
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        mobileMenuButton?.addEventListener('click', toggleMobileMenu);
        mobileMenuClose?.addEventListener('click', toggleMobileMenu);

        // Close menu when clicking a link
        mobileMenu?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>

    {{-- Additional Scripts --}}
    @stack('scripts')
</body>
</html>
