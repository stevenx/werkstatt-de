<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OverpassApiService
{
    protected Client $client;
    protected string $overpassUrl;

    public function __construct()
    {
        $this->overpassUrl = config('services.osm.overpass_url', 'https://overpass-api.de/api/interpreter');
        $this->client = new Client([
            'timeout' => 300,
            'headers' => [
                'User-Agent' => 'werkstatt.de/1.0',
            ],
        ]);
    }

    /**
     * Query for car repair shops in Germany
     *
     * @return array
     * @throws GuzzleException
     */
    public function queryWorkshops(): array
    {
        // Using bbox for Germany instead of area query for better reliability
        // Germany bbox: [47.3, 5.9, 55.1, 15.0] (south, west, north, east)
        $query = <<<'OVERPASS'
[out:json][timeout:300];
(
  node["shop"="car_repair"](47.3,5.9,55.1,15.0);
  way["shop"="car_repair"](47.3,5.9,55.1,15.0);
  node["craft"="car_repair"](47.3,5.9,55.1,15.0);
  way["craft"="car_repair"](47.3,5.9,55.1,15.0);
);
out body;
>;
out skel qt;
OVERPASS;

        Log::info('Querying Overpass API for workshops');
        return $this->executeQuery($query);
    }

    /**
     * Query for vehicle inspection stations (TÜV) in Germany
     *
     * @return array
     * @throws GuzzleException
     */
    public function queryTuvStations(): array
    {
        // Using bbox for Germany for better reliability
        $query = <<<'OVERPASS'
[out:json][timeout:300];
(
  node["amenity"="vehicle_inspection"](47.3,5.9,55.1,15.0);
  way["amenity"="vehicle_inspection"](47.3,5.9,55.1,15.0);
  node["office"="vehicle_inspection"](47.3,5.9,55.1,15.0);
  way["office"="vehicle_inspection"](47.3,5.9,55.1,15.0);
);
out body;
>;
out skel qt;
OVERPASS;

        Log::info('Querying Overpass API for TÜV stations');
        return $this->executeQuery($query);
    }

    /**
     * Query for tire shops/dealers in Germany
     *
     * @return array
     * @throws GuzzleException
     */
    public function queryTireDealers(): array
    {
        // Using bbox for Germany for better reliability
        $query = <<<'OVERPASS'
[out:json][timeout:300];
(
  node["shop"="tyres"](47.3,5.9,55.1,15.0);
  way["shop"="tyres"](47.3,5.9,55.1,15.0);
  node["shop"="car_parts"]["service:tyres"="yes"](47.3,5.9,55.1,15.0);
  way["shop"="car_parts"]["service:tyres"="yes"](47.3,5.9,55.1,15.0);
);
out body;
>;
out skel qt;
OVERPASS;

        Log::info('Querying Overpass API for tire dealers');
        return $this->executeQuery($query);
    }

    /**
     * Execute an Overpass QL query
     *
     * @param string $query
     * @return array
     * @throws GuzzleException
     */
    protected function executeQuery(string $query): array
    {
        try {
            $response = $this->client->post($this->overpassUrl, [
                'form_params' => [
                    'data' => $query,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['elements'])) {
                Log::warning('Overpass API returned unexpected response format');
                return [];
            }

            Log::info('Overpass API query successful', ['count' => count($data['elements'])]);
            return $data['elements'];

        } catch (GuzzleException $e) {
            Log::error('Overpass API query failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            // If rate limited (HTTP 429), throw exception to be handled by caller
            if ($e->getCode() === 429) {
                throw $e;
            }

            return [];
        }
    }

    /**
     * Parse an OSM element into an array suitable for database storage
     *
     * @param array $element
     * @return array
     */
    public function parseOsmElement(array $element): array
    {
        $tags = $element['tags'] ?? [];

        // Extract address components
        $street = $tags['addr:street'] ?? null;
        $houseNumber = $tags['addr:housenumber'] ?? null;
        $postalCode = $tags['addr:postcode'] ?? null;
        $city = $tags['addr:city'] ?? null;
        $state = $tags['addr:state'] ?? null;

        // Get coordinates
        $latitude = null;
        $longitude = null;

        if ($element['type'] === 'node') {
            $latitude = $element['lat'] ?? null;
            $longitude = $element['lon'] ?? null;
        } elseif (isset($element['center'])) {
            $latitude = $element['center']['lat'] ?? null;
            $longitude = $element['center']['lon'] ?? null;
        }

        // Extract name (try multiple fields)
        $name = $tags['name'] ??
                $tags['operator'] ??
                $tags['brand'] ??
                'Unknown Location';

        // Extract opening hours
        $openingHours = null;
        if (isset($tags['opening_hours'])) {
            $openingHours = $this->parseOpeningHours($tags['opening_hours']);
        }

        // Extract contact information
        $phone = $tags['phone'] ?? $tags['contact:phone'] ?? null;
        $email = $tags['email'] ?? $tags['contact:email'] ?? null;
        $website = $tags['website'] ?? $tags['contact:website'] ?? null;

        // Clean phone number
        if ($phone) {
            $phone = $this->cleanPhoneNumber($phone);
        }

        return [
            'osm_id' => $element['type'] . '/' . $element['id'],
            'osm_type' => $element['type'],
            'name' => $name,
            'street' => $street,
            'house_number' => $houseNumber,
            'postal_code' => $postalCode,
            'city' => $city,
            'state' => $state,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'phone' => $phone,
            'email' => $email,
            'website' => $website,
            'opening_hours' => $openingHours,
            'tags' => $tags,
        ];
    }

    /**
     * Parse opening hours string into structured format
     *
     * @param string $openingHours
     * @return array|null
     */
    protected function parseOpeningHours(string $openingHours): ?array
    {
        // For now, store as simple key-value
        // Can be enhanced later for more complex parsing
        return ['raw' => $openingHours];
    }

    /**
     * Clean and normalize phone number
     *
     * @param string $phone
     * @return string
     */
    protected function cleanPhoneNumber(string $phone): string
    {
        // Remove common formatting
        $phone = trim($phone);

        // Handle multiple numbers separated by semicolon (take first)
        if (str_contains($phone, ';')) {
            $phone = explode(';', $phone)[0];
        }

        return $phone;
    }

    /**
     * Extract workshop-specific details from tags
     *
     * @param array $tags
     * @return array
     */
    public function extractWorkshopDetails(array $tags): array
    {
        $services = [];
        $brands = [];

        // Extract services
        if (isset($tags['service'])) {
            $services = array_map('trim', explode(';', $tags['service']));
        }

        // Check for specific service tags
        $serviceChecks = [
            'service:vehicle:repair' => 'Repair',
            'service:vehicle:maintenance' => 'Maintenance',
            'service:vehicle:inspection' => 'Inspection',
            'service:vehicle:bodywork' => 'Bodywork',
            'service:vehicle:painting' => 'Painting',
            'service:vehicle:tyres' => 'Tires',
            'service:vehicle:air_conditioning' => 'Air Conditioning',
            'service:vehicle:diagnostics' => 'Diagnostics',
            'service:vehicle:oil_change' => 'Oil Change',
            'service:vehicle:brakes' => 'Brakes',
        ];

        foreach ($serviceChecks as $tag => $serviceName) {
            if (isset($tags[$tag]) && $tags[$tag] === 'yes') {
                $services[] = $serviceName;
            }
        }

        // Extract brands
        if (isset($tags['brand'])) {
            $brands = array_map('trim', explode(';', $tags['brand']));
        }

        // Extract certifications
        $certifications = [];
        if (isset($tags['certification'])) {
            $certifications = array_map('trim', explode(';', $tags['certification']));
        }

        return [
            'services' => !empty($services) ? $services : null,
            'brands_serviced' => !empty($brands) ? $brands : null,
            'certifications' => !empty($certifications) ? $certifications : null,
        ];
    }

    /**
     * Extract TÜV-specific details from tags
     *
     * @param array $tags
     * @return array
     */
    public function extractTuvDetails(array $tags): array
    {
        $inspectionTypes = [];

        // Common inspection types
        $inspectionChecks = [
            'vehicle_inspection:car' => 'Car Inspection',
            'vehicle_inspection:motorcycle' => 'Motorcycle Inspection',
            'vehicle_inspection:truck' => 'Truck Inspection',
            'vehicle_inspection:trailer' => 'Trailer Inspection',
        ];

        foreach ($inspectionChecks as $tag => $type) {
            if (isset($tags[$tag]) && $tags[$tag] === 'yes') {
                $inspectionTypes[] = $type;
            }
        }

        // If no specific types found, add generic
        if (empty($inspectionTypes)) {
            $inspectionTypes[] = 'General Vehicle Inspection';
        }

        return [
            'inspection_types' => $inspectionTypes,
            'appointment_required' => isset($tags['appointment']) && $tags['appointment'] === 'required',
        ];
    }

    /**
     * Extract tire dealer-specific details from tags
     *
     * @param array $tags
     * @return array
     */
    public function extractTireDealerDetails(array $tags): array
    {
        $tireBrands = [];
        $services = [];

        // Extract tire brands
        if (isset($tags['brand'])) {
            $tireBrands = array_map('trim', explode(';', $tags['brand']));
        }

        // Extract services
        $serviceChecks = [
            'service:tyres' => 'Tire Sales',
            'service:tyres:fitting' => 'Tire Fitting',
            'service:tyres:storage' => 'Tire Storage',
            'service:vehicle:wheel_alignment' => 'Wheel Alignment',
            'service:vehicle:wheel_balancing' => 'Wheel Balancing',
        ];

        foreach ($serviceChecks as $tag => $serviceName) {
            if (isset($tags[$tag]) && $tags[$tag] === 'yes') {
                $services[] = $serviceName;
            }
        }

        return [
            'tire_brands' => !empty($tireBrands) ? $tireBrands : null,
            'services' => !empty($services) ? $services : null,
            'tire_storage_available' => isset($tags['service:tyres:storage']) && $tags['service:tyres:storage'] === 'yes',
            'wheel_alignment' => isset($tags['service:vehicle:wheel_alignment']) && $tags['service:vehicle:wheel_alignment'] === 'yes',
            'balancing_available' => isset($tags['service:vehicle:wheel_balancing']) && $tags['service:vehicle:wheel_balancing'] === 'yes',
        ];
    }
}
