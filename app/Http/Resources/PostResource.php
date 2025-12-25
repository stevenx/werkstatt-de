<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->toIso8601String(),
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'email' => $this->when(
                    $request->user()?->id === $this->author_id,
                    $this->author->email
                ),
            ],
            'seo' => [
                'meta_title' => $this->meta_title ?? $this->title,
                'meta_description' => $this->meta_description ?? $this->excerpt,
                'meta_keywords' => $this->meta_keywords,
            ],
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'links' => [
                'self' => route('posts.show', ['slug' => $this->slug]),
                'api' => url("/api/posts/{$this->id}"),
            ],
        ];
    }
}
