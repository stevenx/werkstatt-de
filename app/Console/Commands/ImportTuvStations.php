<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\TuvDetail;
use App\Services\OverpassApiService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportTuvStations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tuv
                          {--limit= : Limit the number of locations to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import TÜV/vehicle inspection stations from OpenStreetMap';

    protected OverpassApiService $overpassService;
    protected int $newCount = 0;
    protected int $updatedCount = 0;
    protected int $unchangedCount = 0;
    protected int $errorCount = 0;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->overpassService = app(OverpassApiService::class);

        $this->info('Starting TÜV station import from OpenStreetMap...');
        $this->newLine();

        try {
            // Query Overpass API
            $this->info('Querying Overpass API for TÜV stations in Germany...');
            $elements = $this->overpassService->queryTuvStations();

            if (empty($elements)) {
                $this->warn('No TÜV stations found from Overpass API');
                return Command::SUCCESS;
            }

            $this->info(sprintf('Found %d TÜV stations from OSM', count($elements)));
            $this->newLine();

            // Apply limit if specified
            $limit = $this->option('limit');
            if ($limit) {
                $elements = array_slice($elements, 0, (int) $limit);
                $this->info(sprintf('Limited to %d TÜV stations', count($elements)));
            }

            // Process elements with progress bar
            $progressBar = $this->output->createProgressBar(count($elements));
            $progressBar->start();

            foreach ($elements as $element) {
                try {
                    $this->processTuvStation($element);
                } catch (\Exception $e) {
                    $this->errorCount++;
                    Log::error('Failed to process TÜV station', [
                        'osm_id' => $element['id'] ?? 'unknown',
                        'error' => $e->getMessage(),
                    ]);
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine(2);

            // Display statistics
            $this->displayStatistics();

            return Command::SUCCESS;

        } catch (GuzzleException $e) {
            $this->error('Failed to query Overpass API: ' . $e->getMessage());

            if ($e->getCode() === 429) {
                $this->warn('Rate limit reached. Please try again later.');
            }

            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error('Import failed: ' . $e->getMessage());
            Log::error('TÜV import failed', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }

    /**
     * Process a single TÜV station element
     *
     * @param array $element
     * @return void
     */
    protected function processTuvStation(array $element): void
    {
        // Skip elements without tags
        if (!isset($element['tags'])) {
            return;
        }

        // Parse OSM element
        $data = $this->overpassService->parseOsmElement($element);

        // Skip if no valid coordinates
        if (!$data['latitude'] || !$data['longitude']) {
            return;
        }

        DB::beginTransaction();

        try {
            // Find or create location
            $location = Location::where('osm_id', $data['osm_id'])->first();

            $locationData = [
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'type' => 'tuv',
                'street' => $data['street'],
                'house_number' => $data['house_number'],
                'postal_code' => $data['postal_code'],
                'city' => $data['city'],
                'state' => $data['state'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'website' => $data['website'],
                'opening_hours' => $data['opening_hours'],
                'osm_id' => $data['osm_id'],
                'osm_type' => $data['osm_type'],
                'last_synced_at' => now(),
            ];

            if ($location) {
                // Check if anything changed
                $hasChanges = false;
                foreach ($locationData as $key => $value) {
                    if ($key !== 'last_synced_at' && $location->$key != $value) {
                        $hasChanges = true;
                        break;
                    }
                }

                if ($hasChanges) {
                    $location->update($locationData);
                    $this->updatedCount++;
                } else {
                    $location->touch('last_synced_at');
                    $this->unchangedCount++;
                }
            } else {
                $location = Location::create($locationData);
                $this->newCount++;
            }

            // Extract and save TÜV details
            $tuvData = $this->overpassService->extractTuvDetails($data['tags']);

            TuvDetail::updateOrCreate(
                ['location_id' => $location->id],
                [
                    'inspection_types' => $tuvData['inspection_types'],
                    'appointment_required' => $tuvData['appointment_required'],
                ]
            );

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display import statistics
     *
     * @return void
     */
    protected function displayStatistics(): void
    {
        $this->info('Import Statistics:');
        $this->table(
            ['Status', 'Count'],
            [
                ['New TÜV stations', $this->newCount],
                ['Updated TÜV stations', $this->updatedCount],
                ['Unchanged TÜV stations', $this->unchangedCount],
                ['Errors', $this->errorCount],
                ['Total processed', $this->newCount + $this->updatedCount + $this->unchangedCount],
            ]
        );

        if ($this->errorCount > 0) {
            $this->warn('Some TÜV stations failed to import. Check logs for details.');
        }
    }
}
