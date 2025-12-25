<?php

namespace App\Services;

use App\Models\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    protected Client $client;

    protected array $endpoints;

    protected int $maxAttempts;

    protected int $delaySeconds;

    protected int $timeout;

    public function __construct()
    {
        $this->client = new Client();
        $this->endpoints = config('webhooks.endpoints', []);
        $this->maxAttempts = config('webhooks.retry.max_attempts', 3);
        $this->delaySeconds = config('webhooks.retry.delay_seconds', 5);
        $this->timeout = config('webhooks.timeout', 10);
    }

    /**
     * Send post published notification to all configured webhooks.
     */
    public function sendPostPublished(Post $post): void
    {
        $payload = $this->buildPostPayload($post);

        foreach ($this->endpoints as $name => $url) {
            if (empty($url)) {
                continue;
            }

            $this->sendWithRetry($name, $url, $payload);
        }
    }

    /**
     * Build the webhook payload for a post.
     */
    protected function buildPostPayload(Post $post): array
    {
        return [
            'event' => 'post.published',
            'timestamp' => now()->toIso8601String(),
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'content' => $post->content,
                'featured_image' => $post->featured_image,
                'author' => [
                    'id' => $post->author->id,
                    'name' => $post->author->name,
                    'email' => $post->author->email,
                ],
                'published_at' => $post->published_at->toIso8601String(),
                'url' => route('posts.show', ['slug' => $post->slug]),
                'seo' => [
                    'meta_title' => $post->meta_title,
                    'meta_description' => $post->meta_description,
                    'meta_keywords' => $post->meta_keywords,
                ],
            ],
        ];
    }

    /**
     * Send webhook with retry logic.
     */
    protected function sendWithRetry(string $name, string $url, array $payload): void
    {
        $attempt = 1;

        while ($attempt <= $this->maxAttempts) {
            try {
                $response = $this->client->post($url, [
                    'json' => $payload,
                    'timeout' => $this->timeout,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'Werkstatt.de-Webhook/1.0',
                        'X-Webhook-Signature' => $this->generateSignature($payload),
                    ],
                ]);

                if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                    Log::info("Webhook sent successfully to {$name}", [
                        'url' => $url,
                        'post_id' => $payload['data']['id'],
                        'attempt' => $attempt,
                    ]);

                    return;
                }
            } catch (GuzzleException $e) {
                Log::warning("Webhook delivery failed to {$name}", [
                    'url' => $url,
                    'attempt' => $attempt,
                    'error' => $e->getMessage(),
                    'post_id' => $payload['data']['id'],
                ]);
            }

            if ($attempt < $this->maxAttempts) {
                sleep($this->delaySeconds);
            }

            $attempt++;
        }

        Log::error("Webhook delivery failed after {$this->maxAttempts} attempts to {$name}", [
            'url' => $url,
            'post_id' => $payload['data']['id'],
        ]);
    }

    /**
     * Generate a signature for the webhook payload.
     */
    protected function generateSignature(array $payload): string
    {
        $secret = config('app.key');

        return hash_hmac('sha256', json_encode($payload), $secret);
    }
}
