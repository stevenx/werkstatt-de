@extends('layouts.app')

@php
    $metaTitle = 'Blog - Autowerkstatt Tipps & News | Werkstatt.de';
    $metaDescription = 'Lesen Sie aktuelle Artikel rund um Autowerkstätten, Fahrzeugwartung, TÜV und Auto-Reparaturen. Tipps und Tricks für Autobesitzer.';
@endphp

@section('content')
{{-- Page Header --}}
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Blog</h1>
        <p class="text-indigo-100 text-lg">
            Tipps, News und Ratgeber rund um Autowerkstätten und Fahrzeugpflege
        </p>
    </div>
</section>

{{-- Blog Posts --}}
<section class="py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <article class="card-hover bg-white rounded-xl shadow-lg overflow-hidden flex flex-col h-full">
                    {{-- Featured Image --}}
                    @if($post->featured_image)
                    <div class="aspect-video bg-gray-200">
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-indigo-400 to-purple-500"></div>
                    @endif

                    {{-- Content --}}
                    <div class="p-6 flex-1 flex flex-col">
                        {{-- Date --}}
                        <time class="text-sm text-gray-500 mb-2">
                            {{ $post->published_at->format('d. F Y') }}
                        </time>

                        {{-- Title --}}
                        <h2 class="text-2xl font-bold mb-3 text-gray-900 line-clamp-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600">
                                {{ $post->title }}
                            </a>
                        </h2>

                        {{-- Excerpt --}}
                        @if($post->excerpt)
                        <p class="text-gray-600 mb-4 line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                        @endif

                        {{-- Read More --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold inline-flex items-center mt-auto">
                            Weiterlesen
                            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            {{-- No Posts --}}
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Keine Beiträge gefunden</h3>
                <p class="text-gray-600">Schauen Sie später wieder vorbei.</p>
            </div>
        @endif
    </div>
</section>
@endsection
