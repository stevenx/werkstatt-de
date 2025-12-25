<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of locations.
     */
    public function index(Request $request)
    {
        $query = Location::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('postal_code', 'like', '%' . $search . '%')
                    ->orWhere('street', 'like', '%' . $search . '%');
            });
        }

        // Apply type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $locations = $query->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('locations.index', compact('locations'));
    }

    /**
     * Display the specified location.
     */
    public function show(string $slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();

        return view('locations.show', compact('location'));
    }
}
