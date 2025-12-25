# OpenStreetMap Import System

Complete documentation for the werkstatt.de OpenStreetMap import system.

## Overview

This system imports car repair workshops, TÜV stations, and tire dealers from OpenStreetMap data for Germany using the Overpass API.

## Components

### 1. OverpassApiService

**Location:** `app/Services/OverpassApiService.php`

Core service that interfaces with the Overpass API to query and parse OpenStreetMap data.

#### Methods:

- `queryWorkshops()` - Query for car repair shops in Germany
- `queryTuvStations()` - Query for vehicle inspection stations
- `queryTireDealers()` - Query for tire shops
- `parseOsmElement($element)` - Parse OSM element to array for database
- `extractWorkshopDetails($tags)` - Extract workshop-specific details
- `extractTuvDetails($tags)` - Extract TÜV-specific details
- `extractTireDealerDetails($tags)` - Extract tire dealer-specific details

#### Features:

- Queries Overpass API with proper timeout handling (300 seconds)
- Filters data by Germany (ISO3166-1=DE)
- Extracts address components (street, house number, postal code, city, state)
- Parses contact information (phone, email, website)
- Handles opening hours
- Rate limiting detection and error handling
- Comprehensive logging

### 2. Import Commands

#### ImportWorkshops

**Command:** `import:workshops`
**Location:** `app/Console/Commands/ImportWorkshops.php`

Imports car repair workshops from OpenStreetMap.

**Usage:**
```bash
php artisan import:workshops
php artisan import:workshops --limit=100
```

**Options:**
- `--limit` - Limit the number of locations to import

**OSM Tags Queried:**
- `shop=car_repair`
- `craft=car_repair`

#### ImportTuvStations

**Command:** `import:tuv`
**Location:** `app/Console/Commands/ImportTuvStations.php`

Imports TÜV/vehicle inspection stations from OpenStreetMap.

**Usage:**
```bash
php artisan import:tuv
php artisan import:tuv --limit=100
```

**Options:**
- `--limit` - Limit the number of locations to import

**OSM Tags Queried:**
- `amenity=vehicle_inspection`
- `office=vehicle_inspection`

#### ImportTireDealers

**Command:** `import:tire-dealers`
**Location:** `app/Console/Commands/ImportTireDealers.php`

Imports tire dealers/shops from OpenStreetMap.

**Usage:**
```bash
php artisan import:tire-dealers
php artisan import:tire-dealers --limit=100
```

**Options:**
- `--limit` - Limit the number of locations to import

**OSM Tags Queried:**
- `shop=tyres`
- `shop=car_parts` with `service:tyres=yes`

#### ImportAllLocations

**Command:** `import:all-locations`
**Location:** `app/Console/Commands/ImportAllLocations.php`

Orchestrates all three imports and provides comprehensive statistics.

**Usage:**
```bash
php artisan import:all-locations
php artisan import:all-locations --limit=50
```

**Options:**
- `--limit` - Limit the number of locations to import per type

**Features:**
- Runs all three imports sequentially
- Provides overall summary
- Shows database statistics
- Displays total duration
- Handles failures gracefully

## Database Structure

### Locations Table

Main table storing all location data:

- `id` - Primary key
- `type` - Enum: workshop, tuv, tire_dealer
- `name` - Location name
- `slug` - URL-friendly slug (auto-generated)
- `street` - Street name
- `house_number` - House number
- `postal_code` - Postal code
- `city` - City name
- `state` - State/region
- `latitude` - Latitude coordinate
- `longitude` - Longitude coordinate
- `phone` - Phone number
- `email` - Email address
- `website` - Website URL
- `opening_hours` - JSON opening hours data
- `osm_id` - Unique OSM identifier (format: type/id)
- `osm_type` - OSM element type (node, way, relation)
- `last_synced_at` - Last sync timestamp
- `created_at`, `updated_at` - Laravel timestamps

### Detail Tables

- `workshop_details` - Workshop-specific data (services, brands, certifications)
- `tuv_details` - TÜV-specific data (inspection types, appointment requirements)
- `tire_dealer_details` - Tire dealer-specific data (tire brands, services)

## Configuration

Add to `.env`:

```env
OSM_OVERPASS_URL=https://overpass-api.de/api/interpreter
```

The configuration is stored in `config/services.php`:

```php
'osm' => [
    'overpass_url' => env('OSM_OVERPASS_URL', 'https://overpass-api.de/api/interpreter'),
],
```

## Import Process

1. **Query Overpass API** - Fetch OSM elements based on specific tags for Germany
2. **Parse Elements** - Extract and normalize data from OSM format
3. **Upsert Locations** - Create or update location records
4. **Update Details** - Create or update type-specific detail records
5. **Track Changes** - Log new, updated, and unchanged records
6. **Update Sync Time** - Record `last_synced_at` timestamp

## Features

### Deduplication

The system uses `osm_id` as a unique identifier to prevent duplicate imports. Updates are tracked and only modified records are updated.

### Slug Generation

Slugs are automatically generated from location names using Laravel's `Str::slug()` helper. The slug is updated whenever the name changes.

### Address Formatting

The `Location` model provides a `formatted_address` accessor that combines street, house number, postal code, city, and state into a readable format.

### Change Detection

The import commands detect changes by comparing existing data with new data. Statistics show:
- New locations created
- Existing locations updated
- Unchanged locations (only `last_synced_at` updated)
- Errors encountered

### Error Handling

- Graceful handling of API errors
- Rate limit detection (HTTP 429)
- Transaction support (rollback on error)
- Comprehensive error logging
- Progress indicators

### Logging

All import operations are logged using Laravel's logging system:
- API query start/completion
- Element counts
- Individual errors
- Rate limiting events

## Scopes

The `Location` model provides query scopes for easy filtering:

```php
Location::workshops()->get();
Location::tuv()->get();
Location::tireDealers()->get();
```

## Example Output

```
Starting workshop import from OpenStreetMap...

Querying Overpass API for workshops in Germany...
Found 1234 workshops from OSM

 1234/1234 [============================] 100%

Import Statistics:
+-----------------------+-------+
| Status                | Count |
+-----------------------+-------+
| New workshops         | 1100  |
| Updated workshops     | 100   |
| Unchanged workshops   | 34    |
| Errors                | 0     |
| Total processed       | 1234  |
+-----------------------+-------+
```

## Rate Limiting

The Overpass API has rate limits. If you encounter a 429 error:

1. Wait a few minutes before retrying
2. Use the `--limit` option to import in smaller batches
3. Consider using a different Overpass API endpoint

## Scheduling

To keep data up-to-date, add to `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('import:all-locations')->weekly();
```

Or run manually via cron:

```cron
0 2 * * 0 cd /path/to/werkstatt.de && php artisan import:all-locations
```

## Dependencies

- GuzzleHTTP - HTTP client for API requests
- Laravel 11+ - Framework
- PHP 8.2+ - PHP version

## Troubleshooting

### No results returned

- Check Overpass API status
- Verify OSM_OVERPASS_URL is correct
- Try with `--limit=10` to test

### Rate limit errors

- Wait before retrying
- Use smaller batches with `--limit`
- Consider alternative Overpass endpoints

### Database errors

- Run migrations: `php artisan migrate`
- Check database connection
- Verify table structure matches models

## Future Enhancements

Potential improvements:

1. **Advanced Opening Hours Parsing** - Parse opening_hours into structured format
2. **Geocoding Validation** - Verify coordinates are within Germany
3. **Image Import** - Download and store location photos
4. **Review Integration** - Link with Google Places for reviews
5. **Incremental Updates** - Only update changed records based on OSM timestamps
6. **Multi-Country Support** - Extend beyond Germany
7. **API Caching** - Cache Overpass responses to reduce API calls
8. **WebSocket Progress** - Real-time import progress in admin panel

## License

Part of werkstatt.de project.
