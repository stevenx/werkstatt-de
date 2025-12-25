<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get counts by type
        $workshopCount = Location::where('type', 'workshop')->count();
        $tuvCount = Location::where('type', 'tuv')->count();
        $tireDealerCount = Location::where('type', 'tire_dealer')->count();

        // Get latest published posts
        $latestPosts = Post::published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('home', compact(
            'workshopCount',
            'tuvCount',
            'tireDealerCount',
            'latestPosts'
        ));
    }
}
