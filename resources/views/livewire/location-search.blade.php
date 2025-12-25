<div class="space-y-6">
    {{-- Premium Search and Filters --}}
    <div class="card-premium p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Search Input --}}
            <div class="lg:col-span-8">
                <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Suche nach Name, Stadt oder PLZ
                </label>
                <div class="relative">
                    <input type="text"
                           id="search"
                           wire:model.live.debounce.300ms="search"
                           placeholder="z.B. München, 80331, oder Werkstattname..."
                           class="input-premium">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Type Filter --}}
            <div class="lg:col-span-4">
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Typ filtern
                </label>
                <select id="type"
                        wire:model.live="type"
                        class="input-premium appearance-none cursor-pointer">
                    <option value="">Alle Typen</option>
                    <option value="workshop">Werkstatt</option>
                    <option value="tuv">TÜV</option>
                    <option value="tire_dealer">Reifenhändler</option>
                </select>
            </div>
        </div>

        {{-- Active Filters & Clear Button --}}
        @if($search || $type)
        <div class="mt-6 flex items-center justify-between flex-wrap gap-4 pt-6 border-t border-gray-200">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-sm font-medium text-gray-600">Aktive Filter:</span>
                @if($search)
                <span class="badge-premium bg-indigo-100 text-indigo-800 inline-flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Suche: "{{ $search }}"
                </span>
                @endif
                @if($type)
                <span class="badge-premium bg-indigo-100 text-indigo-800 inline-flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
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
                    class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold inline-flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Filter zurücksetzen
            </button>
        </div>
        @endif
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="flex justify-center py-12">
        <div class="spinner"></div>
    </div>

    {{-- Results --}}
    <div wire:loading.remove>
        @if($locations->count() > 0)
            {{-- Results Header --}}
            <div class="mb-6">
                <p class="text-gray-600">
                    <span class="font-semibold text-gray-900">{{ number_format($locations->total()) }}</span>
                    {{ $locations->total() === 1 ? 'Ergebnis' : 'Ergebnisse' }} gefunden
                </p>
            </div>

            {{-- Results Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($locations as $location)
                <article class="card-premium group">
                    <div class="p-6">
                        {{-- Type Badge --}}
                        <div class="mb-4">
                            @if($location->type === 'workshop')
                                <x-badge type="workshop">Werkstatt</x-badge>
                            @elseif($location->type === 'tuv')
                                <x-badge type="tuv">TÜV</x-badge>
                            @elseif($location->type === 'tire_dealer')
                                <x-badge type="tire_dealer">Reifenhändler</x-badge>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h3 class="text-xl font-bold mb-3 text-gray-900 group-hover:text-indigo-600 transition-colors">
                            <a href="{{ route('locations.show', $location->slug) }}" class="line-clamp-2">
                                {{ $location->name }}
                            </a>
                        </h3>

                        {{-- Address --}}
                        <div class="flex items-start text-gray-600 mb-3">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:{{ $location->phone }}" class="text-sm hover:text-indigo-600 transition-colors font-medium">{{ $location->phone }}</a>
                        </div>
                        @endif

                        {{-- Website --}}
                        @if($location->website)
                        <div class="flex items-center text-gray-600 mb-6">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <a href="{{ $location->website }}" target="_blank" rel="noopener" class="text-sm hover:text-indigo-600 transition-colors truncate font-medium">Website besuchen</a>
                        </div>
                        @endif

                        {{-- View Details Button --}}
                        <a href="{{ route('locations.show', $location->slug) }}" class="btn-premium btn-primary w-full justify-center text-sm py-3">
                            Details anzeigen
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
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
            <div class="empty-state card-premium">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-900">Keine Ergebnisse gefunden</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Leider konnten wir keine Standorte finden, die zu Ihren Suchkriterien passen. Versuchen Sie es mit anderen Begriffen oder Filtern.
                </p>
                <button wire:click="clearFilters" class="btn-premium btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Filter zurücksetzen
                </button>
            </div>
        @endif
    </div>
</div>
