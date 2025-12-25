@extends('layouts.app')

@section('content')
{{-- Page Header --}}
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">
            @if(request('type') === 'workshop')
                Autowerkstätten finden
            @elseif(request('type') === 'tuv')
                TÜV-Stationen finden
            @elseif(request('type') === 'tire_dealer')
                Reifenhändler finden
            @else
                Alle Standorte
            @endif
        </h1>
        <p class="text-indigo-100 text-lg">
            {{ $locations->total() }} Ergebnisse gefunden
        </p>
    </div>
</section>

{{-- Search and Filters --}}
<section class="bg-white border-b border-gray-200 py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @livewire('location-search')
    </div>
</section>

{{-- Results --}}
<section class="py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if($locations->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($locations as $location)
                <article class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        {{-- Type Badge --}}
                        <div class="mb-3">
                            @if($location->type === 'workshop')
                                <span class="badge badge-workshop">Werkstatt</span>
                            @elseif($location->type === 'tuv')
                                <span class="badge badge-tuv">TÜV</span>
                            @elseif($location->type === 'tire_dealer')
                                <span class="badge badge-tire-dealer">Reifenhändler</span>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h3 class="text-xl font-bold mb-2 text-gray-900">
                            <a href="{{ route('locations.show', $location->slug) }}" class="hover:text-indigo-600">
                                {{ $location->name }}
                            </a>
                        </h3>

                        {{-- Address --}}
                        <div class="flex items-start text-gray-600 mb-3">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="text-sm">
                                @if($location->street)
                                    {{ $location->street }} {{ $location->house_number }}<br>
                                @endif
                                {{ $location->postal_code }} {{ $location->city }}
                            </div>
                        </div>

                        {{-- Phone --}}
                        @if($location->phone)
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:{{ $location->phone }}" class="text-sm hover:text-indigo-600">{{ $location->phone }}</a>
                        </div>
                        @endif

                        {{-- Website --}}
                        @if($location->website)
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <a href="{{ $location->website }}" target="_blank" rel="noopener" class="text-sm hover:text-indigo-600 truncate">Website</a>
                        </div>
                        @endif

                        {{-- View Details Button --}}
                        <a href="{{ route('locations.show', $location->slug) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition duration-200">
                            Details anzeigen
                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $locations->links() }}
            </div>
        @else
            {{-- No Results --}}
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Keine Ergebnisse gefunden</h3>
                <p class="text-gray-600 mb-6">Versuchen Sie es mit anderen Suchbegriffen oder Filtern.</p>
                <a href="{{ route('locations.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition duration-200">
                    Alle Standorte anzeigen
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
