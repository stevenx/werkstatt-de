<div>
    {{-- Search and Filters --}}
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search Input --}}
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    Suche nach Name, Stadt oder PLZ
                </label>
                <div class="relative">
                    <input type="text" 
                           id="search"
                           wire:model.live.debounce.300ms="search" 
                           placeholder="z.B. München, 80331, oder Werkstattname..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Type Filter --}}
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Typ
                </label>
                <select id="type"
                        wire:model.live="type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Alle Typen</option>
                    <option value="workshop">Werkstatt</option>
                    <option value="tuv">TÜV</option>
                    <option value="tire_dealer">Reifenhändler</option>
                </select>
            </div>
        </div>

        {{-- Active Filters & Clear Button --}}
        @if($search || $type)
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Aktive Filter:</span>
                @if($search)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    Suche: "{{ $search }}"
                </span>
                @endif
                @if($type)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    @if($type === 'workshop')
                        Werkstatt
                    @elseif($type === 'tuv')
                        TÜV
                    @elseif($type === 'tire_dealer')
                        Reifenhändler
                    @endif
                </span>
                @endif
            </div>
            <button wire:click="clearFilters" 
                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                Filter zurücksetzen
            </button>
        </div>
        @endif
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="flex justify-center py-4">
        <div class="spinner"></div>
    </div>

    {{-- Results --}}
    <div wire:loading.remove>
        @if($locations->count() > 0)
            {{-- Results Grid --}}
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
            <div class="mt-8">
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
                <button wire:click="clearFilters" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition duration-200">
                    Filter zurücksetzen
                </button>
            </div>
        @endif
    </div>
</div>
