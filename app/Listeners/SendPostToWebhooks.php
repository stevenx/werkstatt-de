<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPostToWebhooks implements ShouldQueue
{
    /**
     * The webhook service instance.
     */
    protected WebhookService $webhookService;

    /**
     * Create the event listener.
     */
    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $this->webhookService->sendPostPublished($event->post);
    }

    /**
     * Determine whether the listener should be queued.
     */
    public function shouldQueue(PostPublished $event): bool
    {
        return $event->post->is_published;
    }
}
