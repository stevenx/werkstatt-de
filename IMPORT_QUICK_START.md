# OpenStreetMap Import - Quick Start Guide

## Prerequisites

1. Database migrations must be run:
```bash
php artisan migrate
```

2. Environment variable configured in `.env`:
```env
OSM_OVERPASS_URL=https://overpass-api.de/api/interpreter
```

## Available Commands

### Import All Locations (Recommended)
```bash
# Import all location types
php artisan import:all-locations

# Import with limit (for testing)
php artisan import:all-locations --limit=50
```

### Individual Imports

```bash
# Import only workshops
php artisan import:workshops

# Import only TÜV stations
php artisan import:tuv

# Import only tire dealers
php artisan import:tire-dealers
```

## Testing the Import

```bash
# Test with small dataset first
php artisan import:workshops --limit=10
```

## Check Results

After running an import, check the database:

```bash
php artisan tinker
```

Then in tinker:
```php
// Get total counts
\App\Models\Location::count();
\App\Models\Location::workshops()->count();
\App\Models\Location::tuv()->count();
\App\Models\Location::tireDealers()->count();

// View recent imports
\App\Models\Location::latest('last_synced_at')->take(5)->get();

// View a workshop with details
$workshop = \App\Models\Location::workshops()->with('workshopDetail')->first();
```

## File Locations

### Core Files
- **Service:** `app/Services/OverpassApiService.php`
- **Commands:** `app/Console/Commands/Import*.php`
- **Model:** `app/Models/Location.php`
- **Config:** `config/services.php`

### Documentation
- **Full Docs:** `docs/OPENSTREETMAP_IMPORT.md`
- **Tests:** `tests/Feature/OverpassApiServiceTest.php`

## Troubleshooting

### Command Not Found
```bash
# Clear cache and recheck
php artisan cache:clear
php artisan config:clear
php artisan list | grep import
```

### Rate Limited
Wait a few minutes and retry with smaller batches:
```bash
php artisan import:workshops --limit=100
```

### No Results
Check that Overpass API is accessible:
```bash
curl "https://overpass-api.de/api/interpreter"
```

## Run Tests

```bash
php artisan test --filter=OverpassApiServiceTest
```

## What Gets Imported

### Workshops
- Car repair shops (`shop=car_repair`)
- Car repair craftsmen (`craft=car_repair`)
- Services, brands, certifications

### TÜV Stations
- Vehicle inspection facilities (`amenity=vehicle_inspection`)
- Inspection offices (`office=vehicle_inspection`)
- Inspection types, appointment requirements

### Tire Dealers
- Tire shops (`shop=tyres`)
- Car parts shops with tire services (`shop=car_parts` + `service:tyres=yes`)
- Tire brands, services, storage availability

## Data Fields

Each location includes:
- Name, address (street, house number, city, postal code, state)
- Coordinates (latitude, longitude)
- Contact info (phone, email, website)
- Opening hours
- OSM metadata (osm_id, osm_type)
- Last sync timestamp

## Scheduling

To run imports automatically, add to your cron:

```cron
# Weekly full import on Sunday at 2 AM
0 2 * * 0 cd /path/to/werkstatt.de && php artisan import:all-locations
```

Or use Laravel's scheduler in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('import:all-locations')->weekly();
```

Then add to cron:
```cron
* * * * * cd /path/to/werkstatt.de && php artisan schedule:run >> /dev/null 2>&1
```

## Expected Import Times

Approximate durations (depends on API response time):

- Workshops: 2-5 minutes (1000-5000 locations)
- TÜV Stations: 1-2 minutes (100-500 locations)
- Tire Dealers: 1-3 minutes (500-2000 locations)
- **Total:** 4-10 minutes for full import

## Next Steps

After successful import:

1. Verify data in database
2. Test location queries in your application
3. Set up scheduled imports
4. Monitor logs for errors
5. Consider adding data enrichment (images, reviews)

## Support

For issues or questions, see the full documentation in `docs/OPENSTREETMAP_IMPORT.md`.
