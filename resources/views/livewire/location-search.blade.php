<div class="space-y-8">
    {{-- INDUSTRIAL SEARCH & FILTERS --}}
    <div class="card-industrial p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Search Input --}}
            <div class="lg:col-span-8">
                <label for="search" class="block text-sm font-bold uppercase tracking-wider text-charcoal-900 mb-3" style="font-family: var(--font-display);">
                    Suche
                </label>
                <input type="text"
                       id="search"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Stadt, PLZ oder Werkstattname..."
                       class="input-industrial">
            </div>

            {{-- Type Filter --}}
            <div class="lg:col-span-4">
                <label for="type" class="block text-sm font-bold uppercase tracking-wider text-charcoal-900 mb-3" style="font-family: var(--font-display);">
                    Typ
                </label>
                <select id="type"
                        wire:model.live="type"
                        class="input-industrial cursor-pointer">
                    <option value="">Alle Typen</option>
                    <option value="workshop">Werkstatt</option>
                    <option value="tuv">TÜV</option>
                    <option value="tire_dealer">Reifenhändler</option>
                </select>
            </div>
        </div>

        {{-- Active Filters --}}
        @if($search || $type)
        <div class="mt-8 flex items-center justify-between flex-wrap gap-4 pt-6 border-t-2 border-charcoal-900">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-sm font-bold uppercase tracking-wider" style="font-family: var(--font-display); color: #6c757d;">Filter:</span>
                @if($search)
                <span class="badge-industrial bg-yellow-500 text-charcoal-900">
                    {{ $search }}
                </span>
                @endif
                @if($type)
                <span class="badge-industrial {{ $type === 'workshop' ? 'badge-workshop' : ($type === 'tuv' ? 'badge-tuv' : 'badge-tire-dealer') }}">
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
                    class="text-sm text-charcoal-900 hover:text-yellow-500 font-bold uppercase tracking-wider transition-colors" style="font-family: var(--font-display);">
                Zurücksetzen
            </button>
        </div>
        @endif

        <div class="card-accent"></div>
    </div>

    {{-- Loading --}}
    <div wire:loading class="flex justify-center py-16">
        <div class="spinner-industrial"></div>
    </div>

    {{-- Results --}}
    <div wire:loading.remove>
        @if($locations->count() > 0)
            {{-- Results Header --}}
            <div class="mb-8">
                <p class="text-lg" style="font-family: var(--font-mono); color: #6c757d;">
                    <span class="font-bold text-charcoal-900 text-2xl">{{ number_format($locations->total()) }}</span>
                    {{ $locations->total() === 1 ? 'Ergebnis' : 'Ergebnisse' }}
                </p>
            </div>

            {{-- Results Grid - Broken Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($locations as $index => $location)
                <article class="card-industrial card-broken group">
                    <div class="p-8">
                        {{-- Type Badge --}}
                        <div class="mb-6">
                            @if($location->type === 'workshop')
                                <span class="badge-industrial badge-workshop">Werkstatt</span>
                            @elseif($location->type === 'tuv')
                                <span class="badge-industrial badge-tuv">TÜV</span>
                            @elseif($location->type === 'tire_dealer')
                                <span class="badge-industrial badge-tire-dealer">Reifenhändler</span>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h3 class="text-2xl font-bold mb-4 text-charcoal-900 group-hover:text-yellow-500 transition-colors" style="font-family: var(--font-display); line-height: 1.2;">
                            <a href="{{ route('locations.show', $location->slug) }}">
                                {{ $location->name }}
                            </a>
                        </h3>

                        {{-- Address --}}
                        <div class="flex items-start mb-4" style="color: #6c757d;">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="text-sm font-semibold">
                                @if($location->street)
                                    {{ $location->street }} {{ $location->house_number }}<br>
                                @endif
                                {{ $location->postal_code }} {{ $location->city }}
                            </div>
                        </div>

                        {{-- Phone --}}
                        @if($location->phone)
                        <div class="flex items-center mb-6" style="color: #6c757d;">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="square" stroke-linejoin="miter" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:{{ $location->phone }}" class="text-sm hover:text-yellow-500 transition-colors font-bold" style="font-family: var(--font-mono);">{{ $location->phone }}</a>
                        </div>
                        @endif

                        {{-- CTA Button --}}
                        <a href="{{ route('locations.show', $location->slug) }}" class="btn-industrial w-full text-sm py-4">
                            Details
                        </a>
                    </div>
                    <div class="card-accent"></div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $locations->links() }}
            </div>
        @else
            {{-- No Results --}}
            <div class="card-industrial text-center p-16">
                <div class="w-24 h-24 bg-charcoal-900 mx-auto mb-8 flex items-center justify-center" style="clip-path: polygon(12px 0, 100% 0, 100% calc(100% - 12px), calc(100% - 12px) 100%, 0 100%, 0 12px);">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="heading-lg text-charcoal-900 mb-4">KEINE ERGEBNISSE</h3>
                <p class="text-gray-600 mb-10 max-w-md mx-auto text-lg">
                    Leider keine passenden Standorte gefunden. Versuchen Sie andere Suchbegriffe.
                </p>
                <button wire:click="clearFilters" class="btn-industrial">
                    Filter zurücksetzen
                </button>
                <div class="card-accent"></div>
            </div>
        @endif
    </div>
</div>
