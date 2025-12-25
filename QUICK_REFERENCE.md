# Werkstatt.de - Quick Reference Guide

## API Endpoints

### Public Endpoints (No Authentication Required)

```bash
# List all published posts (paginated)
GET /api/posts
GET /api/posts?per_page=20

# Get single post
GET /api/posts/{id}
```

### Protected Endpoints (Requires Authentication)

```bash
# Create a new post
POST /api/posts
Headers: Authorization: Bearer {token}
Body: {
  "title": "Post Title",
  "content": "Post content...",
  "excerpt": "Brief summary",
  "published_at": "2025-12-25T10:00:00Z"
}

# Update a post
PUT /api/posts/{id}
Headers: Authorization: Bearer {token}
Body: { "title": "Updated Title" }

# Delete a post
DELETE /api/posts/{id}
Headers: Authorization: Bearer {token}
```

## Artisan Commands

```bash
# Import all OSM locations
php artisan import:all-locations

# Import specific types
php artisan import:workshops
php artisan import:tuv-stations
php artisan import:tire-dealers

# Generate sitemap
php artisan sitemap:generate
php artisan sitemap:generate --output=custom/path/sitemap.xml

# Run scheduler (sitemap runs weekly)
php artisan schedule:run
```

## Blade Components

### Schema Markup - Location

```blade
<x-schema-markup type="location" :data="[
    'name' => $location->name,
    'city' => $location->city,
    'street' => $location->street,
    'house_number' => $location->house_number,
    'postal_code' => $location->postal_code,
    'state' => $location->state,
    'latitude' => $location->latitude,
    'longitude' => $location->longitude,
    'phone' => $location->phone,
    'email' => $location->email,
    'url' => route('locations.show', $location->slug),
]" />
```

### Schema Markup - Blog Post

```blade
<x-schema-markup type="post" :data="[
    'title' => $post->title,
    'excerpt' => $post->excerpt,
    'featured_image' => $post->featured_image,
    'published_at' => $post->published_at,
    'updated_at' => $post->updated_at,
    'author_name' => $post->author->name,
    'url' => route('posts.show', $post->slug),
]" />
```

### Schema Markup - Breadcrumbs

```blade
<x-schema-markup type="breadcrumb" :data="[
    'items' => [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Blog', 'url' => route('posts.index')],
        ['name' => $post->title],
    ]
]" />
```

## Environment Variables

```bash
# OSM Import
OSM_OVERPASS_URL=https://overpass-api.de/api/interpreter

# Webhooks
WEBHOOK_WORDPRESS_URL=https://your-site.com/webhook
WEBHOOK_MEDIUM_URL=https://medium.com/webhook
WEBHOOK_CUSTOM_URL=https://custom.com/webhook

# Webhook Configuration
WEBHOOK_MAX_RETRY_ATTEMPTS=3
WEBHOOK_RETRY_DELAY=5
WEBHOOK_TIMEOUT=10
```

## Queue Worker Setup

```bash
# Run manually
php artisan queue:work

# Or setup Supervisor
sudo nano /etc/supervisor/conf.d/werkstatt-queue.conf
```

Supervisor config:
```ini
[program:werkstatt-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/werkstatt.de/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/werkstatt.de/storage/logs/queue-worker.log
```

## Cron Setup

```bash
# Edit crontab
crontab -e

# Add this line
* * * * * cd /path/to/werkstatt.de && php artisan schedule:run >> /dev/null 2>&1
```

## Testing

### Generate API Token

```bash
php artisan tinker

# In tinker:
$user = User::first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

### Test API with cURL

```bash
# Get posts
curl https://werkstatt.de/api/posts

# Create post
curl -X POST https://werkstatt.de/api/posts \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Post","content":"Test content"}'
```

### Test Webhooks

1. Get a test webhook URL from https://webhook.site
2. Add to .env: `WEBHOOK_CUSTOM_URL=https://webhook.site/your-id`
3. Publish a post via API or admin panel
4. Check webhook.site for the received payload

## File Locations

```
API
├── routes/api.php
├── app/Http/Controllers/Api/PostController.php
└── app/Http/Resources/PostResource.php

Webhooks
├── config/webhooks.php
├── app/Services/WebhookService.php
├── app/Events/PostPublished.php
└── app/Listeners/SendPostToWebhooks.php

SEO
├── app/Console/Commands/GenerateSitemap.php
├── app/Http/Middleware/SetSeoDefaults.php
├── resources/views/components/schema-markup.blade.php
└── public/robots.txt

GitHub Actions
└── .github/workflows/import-osm-data.yml
```

## Webhook Payload Format

```json
{
  "event": "post.published",
  "timestamp": "2025-12-25T18:19:00+00:00",
  "data": {
    "id": 1,
    "title": "Post Title",
    "slug": "post-title",
    "excerpt": "Post excerpt...",
    "content": "Full content...",
    "featured_image": "https://...",
    "author": {
      "id": 1,
      "name": "Author Name",
      "email": "author@example.com"
    },
    "published_at": "2025-12-25T10:00:00+00:00",
    "url": "https://werkstatt.de/blog/post-title",
    "seo": {
      "meta_title": "SEO Title",
      "meta_description": "SEO Description",
      "meta_keywords": "keywords"
    }
  }
}
```

## Troubleshooting

### Queue not processing webhooks
```bash
# Check queue worker is running
ps aux | grep "queue:work"

# Restart queue worker
php artisan queue:restart
php artisan queue:work
```

### Sitemap not generating
```bash
# Check permissions
ls -la public/sitemap.xml

# Generate manually
php artisan sitemap:generate

# Check scheduler
php artisan schedule:list
```

### API returning 404
```bash
# Clear route cache
php artisan route:clear
php artisan route:cache

# Check routes
php artisan route:list --path=api
```

## Production Deployment Checklist

- [ ] Set webhook URLs in production .env
- [ ] Configure queue worker with Supervisor
- [ ] Setup cron for scheduler
- [ ] Generate initial sitemap
- [ ] Clear and cache routes: `php artisan route:cache`
- [ ] Clear and cache config: `php artisan config:cache`
- [ ] Clear and cache views: `php artisan view:cache`
- [ ] Verify robots.txt accessible
- [ ] Verify sitemap.xml accessible
- [ ] Test API endpoints
- [ ] Test webhook delivery
- [ ] Monitor queue worker logs
