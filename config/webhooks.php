<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Webhook Endpoints
    |--------------------------------------------------------------------------
    |
    | Define the webhook endpoints that should receive notifications when
    | posts are published. Set the URL to null or empty string to disable
    | a specific webhook endpoint.
    |
    */

    'endpoints' => [
        'wordpress' => env('WEBHOOK_WORDPRESS_URL'),
        'medium' => env('WEBHOOK_MEDIUM_URL'),
        'custom' => env('WEBHOOK_CUSTOM_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how webhook delivery failures should be handled.
    |
    */

    'retry' => [
        'max_attempts' => env('WEBHOOK_MAX_RETRY_ATTEMPTS', 3),
        'delay_seconds' => env('WEBHOOK_RETRY_DELAY', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum number of seconds to wait for a webhook response.
    |
    */

    'timeout' => env('WEBHOOK_TIMEOUT', 10),

];
