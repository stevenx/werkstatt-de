<?php

namespace App\Livewire;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class LocationSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
    ];

    public function mount()
    {
        $this->search = request('search', '');
        $this->type = request('type', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->type = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Location::query();

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%')
                    ->orWhere('postal_code', 'like', '%' . $this->search . '%')
                    ->orWhere('street', 'like', '%' . $this->search . '%');
            });
        }

        // Apply type filter
        if (!empty($this->type)) {
            $query->where('type', $this->type);
        }

        $locations = $query->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.location-search', [
            'locations' => $locations,
        ]);
    }
}
