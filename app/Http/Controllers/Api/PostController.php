<?php

namespace App\Http\Controllers\Api;

use App\Events\PostPublished;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 15);
        $perPage = min($perPage, 100); // Max 100 items per page

        $posts = Post::query()
            ->published()
            ->with('author:id,name,email')
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        return PostResource::collection($posts);
    }

    /**
     * Display the specified post.
     */
    public function show(string $id): PostResource
    {
        $post = Post::query()
            ->with('author:id,name,email')
            ->findOrFail($id);

        // Only show published posts to unauthenticated users
        if (!auth()->check() && !$post->is_published) {
            abort(404);
        }

        return new PostResource($post);
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request): PostResource
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url|max:500',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $data['author_id'] = auth()->id();

        $post = Post::create($data);

        // Fire event if the post is being published
        if ($post->is_published) {
            event(new PostPublished($post));
        }

        return new PostResource($post->load('author:id,name,email'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, string $id): PostResource
    {
        $post = Post::findOrFail($id);

        // Authorization check - only post author or admin can update
        if ($post->author_id !== auth()->id()) {
            abort(403, 'Unauthorized to update this post');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url|max:500',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $wasPublished = $post->is_published;

        $post->update($validator->validated());

        // Fire event if the post is being published for the first time
        if (!$wasPublished && $post->fresh()->is_published) {
            event(new PostPublished($post));
        }

        return new PostResource($post->load('author:id,name,email'));
    }

    /**
     * Remove the specified post.
     */
    public function destroy(string $id): Response
    {
        $post = Post::findOrFail($id);

        // Authorization check - only post author can delete
        if ($post->author_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this post');
        }

        $post->delete();

        return response()->noContent();
    }
}
