<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     */
    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}
