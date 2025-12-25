<?php

namespace Tests\Feature;

use App\Services\OverpassApiService;
use Tests\TestCase;

class OverpassApiServiceTest extends TestCase
{
    protected OverpassApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OverpassApiService();
    }

    /** @test */
    public function it_parses_osm_node_element_correctly()
    {
        $element = [
            'type' => 'node',
            'id' => 123456789,
            'lat' => 52.5200,
            'lon' => 13.4050,
            'tags' => [
                'name' => 'Test Workshop',
                'shop' => 'car_repair',
                'addr:street' => 'Hauptstraße',
                'addr:housenumber' => '42',
                'addr:postcode' => '10115',
                'addr:city' => 'Berlin',
                'addr:state' => 'Berlin',
                'phone' => '+49 30 12345678',
                'email' => 'info@test-workshop.de',
                'website' => 'https://test-workshop.de',
                'opening_hours' => 'Mo-Fr 08:00-18:00',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('node/123456789', $result['osm_id']);
        $this->assertEquals('node', $result['osm_type']);
        $this->assertEquals('Test Workshop', $result['name']);
        $this->assertEquals('Hauptstraße', $result['street']);
        $this->assertEquals('42', $result['house_number']);
        $this->assertEquals('10115', $result['postal_code']);
        $this->assertEquals('Berlin', $result['city']);
        $this->assertEquals('Berlin', $result['state']);
        $this->assertEquals(52.5200, $result['latitude']);
        $this->assertEquals(13.4050, $result['longitude']);
        $this->assertEquals('+49 30 12345678', $result['phone']);
        $this->assertEquals('info@test-workshop.de', $result['email']);
        $this->assertEquals('https://test-workshop.de', $result['website']);
        $this->assertIsArray($result['opening_hours']);
    }

    /** @test */
    public function it_parses_osm_way_element_with_center_coordinates()
    {
        $element = [
            'type' => 'way',
            'id' => 987654321,
            'center' => [
                'lat' => 48.1351,
                'lon' => 11.5820,
            ],
            'tags' => [
                'name' => 'Test TÜV',
                'amenity' => 'vehicle_inspection',
                'addr:city' => 'München',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('way/987654321', $result['osm_id']);
        $this->assertEquals('way', $result['osm_type']);
        $this->assertEquals('Test TÜV', $result['name']);
        $this->assertEquals('München', $result['city']);
        $this->assertEquals(48.1351, $result['latitude']);
        $this->assertEquals(11.5820, $result['longitude']);
    }

    /** @test */
    public function it_extracts_workshop_details_from_tags()
    {
        $tags = [
            'service:vehicle:repair' => 'yes',
            'service:vehicle:maintenance' => 'yes',
            'service:vehicle:tyres' => 'yes',
            'service:vehicle:oil_change' => 'yes',
            'brand' => 'BMW;Mercedes;Audi',
            'certification' => 'TÜV;DEKRA',
        ];

        $result = $this->service->extractWorkshopDetails($tags);

        $this->assertIsArray($result['services']);
        $this->assertContains('Repair', $result['services']);
        $this->assertContains('Maintenance', $result['services']);
        $this->assertContains('Tires', $result['services']);
        $this->assertContains('Oil Change', $result['services']);

        $this->assertIsArray($result['brands_serviced']);
        $this->assertContains('BMW', $result['brands_serviced']);
        $this->assertContains('Mercedes', $result['brands_serviced']);
        $this->assertContains('Audi', $result['brands_serviced']);

        $this->assertIsArray($result['certifications']);
        $this->assertContains('TÜV', $result['certifications']);
        $this->assertContains('DEKRA', $result['certifications']);
    }

    /** @test */
    public function it_extracts_tuv_details_from_tags()
    {
        $tags = [
            'vehicle_inspection:car' => 'yes',
            'vehicle_inspection:motorcycle' => 'yes',
            'appointment' => 'required',
        ];

        $result = $this->service->extractTuvDetails($tags);

        $this->assertIsArray($result['inspection_types']);
        $this->assertContains('Car Inspection', $result['inspection_types']);
        $this->assertContains('Motorcycle Inspection', $result['inspection_types']);
        $this->assertTrue($result['appointment_required']);
    }

    /** @test */
    public function it_extracts_tire_dealer_details_from_tags()
    {
        $tags = [
            'service:tyres' => 'yes',
            'service:tyres:fitting' => 'yes',
            'service:tyres:storage' => 'yes',
            'service:vehicle:wheel_alignment' => 'yes',
            'service:vehicle:wheel_balancing' => 'yes',
            'brand' => 'Michelin;Continental;Bridgestone',
        ];

        $result = $this->service->extractTireDealerDetails($tags);

        $this->assertIsArray($result['services']);
        $this->assertContains('Tire Sales', $result['services']);
        $this->assertContains('Tire Fitting', $result['services']);
        $this->assertContains('Tire Storage', $result['services']);
        $this->assertContains('Wheel Alignment', $result['services']);
        $this->assertContains('Wheel Balancing', $result['services']);

        $this->assertIsArray($result['tire_brands']);
        $this->assertContains('Michelin', $result['tire_brands']);
        $this->assertContains('Continental', $result['tire_brands']);
        $this->assertContains('Bridgestone', $result['tire_brands']);

        $this->assertTrue($result['tire_storage_available']);
        $this->assertTrue($result['wheel_alignment']);
        $this->assertTrue($result['balancing_available']);
    }

    /** @test */
    public function it_handles_missing_name_gracefully()
    {
        $element = [
            'type' => 'node',
            'id' => 111,
            'lat' => 50.0,
            'lon' => 10.0,
            'tags' => [
                'shop' => 'car_repair',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('Unknown Location', $result['name']);
    }

    /** @test */
    public function it_uses_operator_as_fallback_name()
    {
        $element = [
            'type' => 'node',
            'id' => 222,
            'lat' => 50.0,
            'lon' => 10.0,
            'tags' => [
                'shop' => 'car_repair',
                'operator' => 'ATU Auto-Teile-Unger',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('ATU Auto-Teile-Unger', $result['name']);
    }

    /** @test */
    public function it_uses_brand_as_fallback_name()
    {
        $element = [
            'type' => 'node',
            'id' => 333,
            'lat' => 50.0,
            'lon' => 10.0,
            'tags' => [
                'shop' => 'car_repair',
                'brand' => 'Bosch Car Service',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('Bosch Car Service', $result['name']);
    }

    /** @test */
    public function it_cleans_phone_numbers_with_semicolons()
    {
        $element = [
            'type' => 'node',
            'id' => 444,
            'lat' => 50.0,
            'lon' => 10.0,
            'tags' => [
                'name' => 'Test',
                'phone' => '+49 30 12345678;+49 30 87654321',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        // Should take the first number only
        $this->assertEquals('+49 30 12345678', $result['phone']);
    }

    /** @test */
    public function it_handles_contact_namespace_tags()
    {
        $element = [
            'type' => 'node',
            'id' => 555,
            'lat' => 50.0,
            'lon' => 10.0,
            'tags' => [
                'name' => 'Test',
                'contact:phone' => '+49 30 12345678',
                'contact:email' => 'info@test.de',
                'contact:website' => 'https://test.de',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertEquals('+49 30 12345678', $result['phone']);
        $this->assertEquals('info@test.de', $result['email']);
        $this->assertEquals('https://test.de', $result['website']);
    }

    /** @test */
    public function it_handles_elements_without_coordinates()
    {
        $element = [
            'type' => 'way',
            'id' => 666,
            'tags' => [
                'name' => 'Test',
            ],
        ];

        $result = $this->service->parseOsmElement($element);

        $this->assertNull($result['latitude']);
        $this->assertNull($result['longitude']);
    }
}
