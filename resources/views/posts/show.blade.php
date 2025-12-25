@extends('layouts.app')

@php
    $metaTitle = ($post->meta_title ?? $post->title) . ' | werkstatt.de Blog';
    $metaDescription = $post->meta_description ?? $post->excerpt ?? substr(strip_tags($post->content), 0, 160);
    $metaKeywords = $post->meta_keywords ?? '';
    $ogImage = $post->featured_image ? Storage::url($post->featured_image) : null;
@endphp

@section('content')
{{-- BOLD HERO WITH FEATURED IMAGE --}}
<section class="relative bg-charcoal-900 overflow-hidden">
    @if($post->featured_image)
    {{-- Featured Image with Yellow Gradient Overlay --}}
    <div class="relative h-[70vh] min-h-[500px]">
        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover opacity-40">

        {{-- Yellow Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-charcoal-900/90 via-charcoal-900/70 to-yellow-500/20"></div>

        {{-- Angular Clip-Path Effect on Image --}}
        <div class="absolute bottom-0 left-0 w-full h-32 bg-offwhite transform origin-top-left -skew-y-2"></div>
    </div>
    @else
    <div class="h-48"></div>
    @endif

    {{-- Content Over Image --}}
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-5xl">
                {{-- Date Badge --}}
                <div class="inline-block mb-6 px-6 py-3 bg-yellow-500 border-2 border-charcoal-900" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                    <time class="text-charcoal-900 font-bold uppercase tracking-wider text-sm" style="font-family: var(--font-mono);">{{ $post->published_at->format('d. M Y') }}</time>
                </div>

                {{-- Large Headline --}}
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-none" style="font-family: var(--font-display); letter-spacing: -0.03em;">
                    {{ $post->title }}
                </h1>

                {{-- Yellow Accent Stripe --}}
                <div class="w-64 h-2 bg-yellow-500 mb-8 transform -skew-x-12"></div>

                {{-- Author & Date --}}
                <div class="flex flex-wrap items-center gap-6 text-lg">
                    @if($post->author)
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-500 flex items-center justify-center mr-3" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                            <span class="text-charcoal-900 font-bold text-xl" style="font-family: var(--font-display);">{{ substr($post->author->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-bold" style="font-family: var(--font-display);">{{ $post->author->name }}</p>
                            <p class="text-gray-400 text-sm">Autor</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MAIN ARTICLE CONTENT --}}
<article class="py-16 bg-offwhite">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            {{-- MAIN CONTENT (Wide Format) --}}
            <div class="lg:col-span-8">
                {{-- Excerpt --}}
                @if($post->excerpt)
                <div class="mb-12 p-8 bg-white border-l-8 border-yellow-500" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%);">
                    <p class="text-2xl leading-relaxed text-gray-700 font-semibold italic">
                        {{ $post->excerpt }}
                    </p>
                </div>
                @endif

                {{-- Article Content - Large, Bold Typography --}}
                <div class="prose prose-lg max-w-none bg-white p-12 border-4 border-charcoal-900" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                    <style>
                        .prose {
                            font-family: 'Inter', sans-serif;
                            font-size: 18px;
                            line-height: 1.8;
                            color: #2d2d2d;
                        }
                        .prose h2 {
                            font-family: var(--font-display);
                            font-size: 36px;
                            font-weight: 700;
                            color: #1a1a1a;
                            margin-top: 3rem;
                            margin-bottom: 1.5rem;
                            border-left: 6px solid #FFD60A;
                            padding-left: 1.5rem;
                        }
                        .prose h3 {
                            font-family: var(--font-display);
                            font-size: 28px;
                            font-weight: 700;
                            color: #1a1a1a;
                            margin-top: 2rem;
                            margin-bottom: 1rem;
                        }
                        .prose p {
                            margin-bottom: 1.5rem;
                        }
                        .prose strong {
                            color: #1a1a1a;
                            font-weight: 700;
                        }
                        .prose a {
                            color: #FFD60A;
                            text-decoration: underline;
                            font-weight: 600;
                        }
                        .prose a:hover {
                            color: #FFC300;
                        }
                        .prose ul, .prose ol {
                            margin: 1.5rem 0;
                            padding-left: 2rem;
                        }
                        .prose li {
                            margin-bottom: 0.75rem;
                            padding-left: 0.5rem;
                        }
                        .prose blockquote {
                            border-left: 6px solid #FFD60A;
                            background: #f5f5f5;
                            padding: 1.5rem 2rem;
                            margin: 2rem 0;
                            font-size: 24px;
                            font-style: italic;
                            color: #1a1a1a;
                        }
                        .prose code {
                            font-family: var(--font-mono);
                            background: #1a1a1a;
                            color: #FFD60A;
                            padding: 0.25rem 0.5rem;
                            border-radius: 0;
                            font-size: 16px;
                        }
                        .prose pre {
                            font-family: var(--font-mono);
                            background: #1a1a1a;
                            color: #FFD60A;
                            padding: 1.5rem;
                            margin: 2rem 0;
                            overflow-x: auto;
                            border: 2px solid #2d2d2d;
                        }
                        .prose img {
                            width: 100%;
                            height: auto;
                            margin: 2rem 0;
                            border: 4px solid #1a1a1a;
                            clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);
                        }
                    </style>
                    {!! nl2br(e($post->content)) !!}
                </div>

                {{-- BOTTOM SECTION - Yellow Diagonal Divider --}}
                <div class="relative mt-16">
                    <div class="h-2 bg-yellow-500 transform -skew-x-12 mb-8"></div>

                    {{-- Share Section --}}
                    <div class="bg-charcoal-900 border-4 border-yellow-500 p-8" style="clip-path: polygon(24px 0, 100% 0, 100% calc(100% - 24px), calc(100% - 24px) 100%, 0 100%, 0 24px);">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div>
                                <h3 class="text-2xl font-bold text-yellow-500 mb-3 uppercase" style="font-family: var(--font-display);">Artikel teilen</h3>
                                <div class="flex gap-3">
                                    {{-- Facebook --}}
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 hover:bg-yellow-500 text-yellow-500 hover:text-charcoal-900 flex items-center justify-center transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>

                                    {{-- Twitter --}}
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 hover:bg-yellow-500 text-yellow-500 hover:text-charcoal-900 flex items-center justify-center transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </a>

                                    {{-- LinkedIn --}}
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="w-12 h-12 bg-charcoal-800 border-2 border-yellow-500 hover:bg-yellow-500 text-yellow-500 hover:text-charcoal-900 flex items-center justify-center transition-all" style="clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%);">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Back to Blog Button --}}
                            <a href="{{ route('posts.index') }}" class="px-8 py-4 bg-yellow-500 text-charcoal-900 font-bold uppercase tracking-wider transition-all hover:bg-white hover:transform hover:-translate-y-1" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                                <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="square" stroke-linejoin="miter" d="M15 19l-7-7 7-7" />
                                </svg>
                                Zurück zum Blog
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR (Sticky) --}}
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-6">

                    {{-- Author Card --}}
                    @if($post->author)
                    <div class="bg-charcoal-900 border-4 border-yellow-500 p-6" style="clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);">
                        <h3 class="text-lg font-bold text-yellow-500 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Autor</h3>
                        <div class="flex items-start">
                            <div class="w-16 h-16 bg-yellow-500 flex items-center justify-center flex-shrink-0 mr-4" style="clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                                <span class="text-charcoal-900 font-bold text-2xl" style="font-family: var(--font-display);">{{ substr($post->author->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-white font-bold text-lg mb-1" style="font-family: var(--font-display);">{{ $post->author->name }}</p>
                                <p class="text-gray-400 text-sm">Experte für Autowerkstätten</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Share Buttons (Sticky) --}}
                    <div class="bg-white border-4 border-charcoal-900 p-6" style="clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);">
                        <h3 class="text-lg font-bold text-charcoal-900 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Teilen</h3>
                        <div class="space-y-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}"
                               target="_blank"
                               rel="noopener"
                               class="flex items-center px-4 py-3 bg-charcoal-900 hover:bg-yellow-500 text-white hover:text-charcoal-900 font-bold transition-all" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                               target="_blank"
                               rel="noopener"
                               class="flex items-center px-4 py-3 bg-charcoal-900 hover:bg-yellow-500 text-white hover:text-charcoal-900 font-bold transition-all" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                               target="_blank"
                               rel="noopener"
                               class="flex items-center px-4 py-3 bg-charcoal-900 hover:bg-yellow-500 text-white hover:text-charcoal-900 font-bold transition-all" style="font-family: var(--font-display); clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%);">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                        </div>
                    </div>

                    {{-- Article Info --}}
                    <div class="bg-white border-4 border-charcoal-900 p-6" style="clip-path: polygon(20px 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%, 0 20px);">
                        <h3 class="text-lg font-bold text-charcoal-900 mb-4 uppercase tracking-wider" style="font-family: var(--font-display);">Info</h3>
                        <div class="space-y-3">
                            <div class="border-b-2 border-gray-200 pb-3">
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Veröffentlicht</p>
                                <p class="text-sm font-bold text-charcoal-900" style="font-family: var(--font-mono);">{{ $post->published_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1" style="font-family: var(--font-display);">Aktualisiert</p>
                                <p class="text-sm font-bold text-charcoal-900" style="font-family: var(--font-mono);">{{ $post->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</article>

{{-- DIAGONAL DIVIDER --}}
<div class="relative h-24 bg-charcoal-900 transform origin-top-left -skew-y-2"></div>

{{-- RELATED POSTS --}}
@php
    $relatedPosts = \App\Models\Post::where('id', '!=', $post->id)
        ->where('is_published', true)
        ->latest('published_at')
        ->limit(3)
        ->get();
@endphp

@if($relatedPosts->count() > 0)
<section class="py-20 bg-charcoal-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <div class="flex items-center mb-4">
                <div class="w-2 h-12 bg-yellow-500 mr-6"></div>
                <h2 class="text-4xl md:text-5xl font-bold text-white" style="font-family: var(--font-display); letter-spacing: -0.02em;">
                    WEITERE ARTIKEL
                </h2>
            </div>
            <div class="w-48 h-1 bg-yellow-500 transform -skew-x-12 ml-20"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedPosts as $related)
            <a href="{{ route('posts.show', $related->slug) }}" class="group bg-charcoal-800 border-2 border-charcoal-700 hover:border-yellow-500 transition-all hover:transform hover:-translate-y-2 card-broken overflow-hidden" style="clip-path: polygon(16px 0, 100% 0, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0 100%, 0 16px);">
                @if($related->featured_image)
                <div class="aspect-video bg-gray-700 overflow-hidden">
                    <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-yellow-500 to-red-500"></div>
                @endif
                <div class="p-6">
                    <time class="text-yellow-500 text-xs font-bold uppercase tracking-wider mb-2 block" style="font-family: var(--font-mono);">{{ $related->published_at->format('d. M Y') }}</time>
                    <h3 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-500 transition-colors line-clamp-2" style="font-family: var(--font-display);">{{ $related->title }}</h3>
                    @if($related->excerpt)
                    <p class="text-gray-400 text-sm line-clamp-2">{{ $related->excerpt }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
