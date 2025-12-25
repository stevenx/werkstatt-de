@extends('layouts.app')

@php
    $metaTitle = ($post->meta_title ?? $post->title) . ' | Werkstatt.de Blog';
    $metaDescription = $post->meta_description ?? $post->excerpt ?? substr(strip_tags($post->content), 0, 160);
    $metaKeywords = $post->meta_keywords ?? '';
    $ogImage = $post->featured_image ? Storage::url($post->featured_image) : null;
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
                    <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-indigo-600">Blog</a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium truncate">{{ $post->title }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Article --}}
<article class="py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <header class="mb-8">
                {{-- Date --}}
                <time class="text-gray-500 mb-4 block">
                    {{ $post->published_at->format('d. F Y') }}
                </time>

                {{-- Title --}}
                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-gray-900">
                    {{ $post->title }}
                </h1>

                {{-- Excerpt --}}
                @if($post->excerpt)
                <p class="text-xl text-gray-600 leading-relaxed">
                    {{ $post->excerpt }}
                </p>
                @endif

                {{-- Author --}}
                @if($post->author)
                <div class="flex items-center mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-lg">
                                {{ substr($post->author->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">{{ $post->author->name }}</p>
                            <p class="text-sm text-gray-500">Autor</p>
                        </div>
                    </div>
                </div>
                @endif
            </header>

            {{-- Featured Image --}}
            @if($post->featured_image)
            <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto">
            </div>
            @endif

            {{-- Content --}}
            <div class="prose prose-lg prose-indigo max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>

            {{-- Footer --}}
            <footer class="mt-12 pt-8 border-t border-gray-200">
                {{-- Share Buttons --}}
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Artikel teilen</h3>
                        <div class="flex space-x-2">
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" 
                               target="_blank" 
                               rel="noopener"
                               class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>

                            {{-- Twitter --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}" 
                               target="_blank" 
                               rel="noopener"
                               class="inline-flex items-center justify-center w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-full transition duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post->slug)) }}&title={{ urlencode($post->title) }}" 
                               target="_blank" 
                               rel="noopener"
                               class="inline-flex items-center justify-center w-10 h-10 bg-blue-700 hover:bg-blue-800 text-white rounded-full transition duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Back to Blog --}}
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Zurück zum Blog
                    </a>
                </div>
            </footer>
        </div>
    </div>
</article>
@endsection
