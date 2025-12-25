<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ImportAllLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all-locations
                          {--limit= : Limit the number of locations to import per type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all location types from OpenStreetMap (workshops, TÜV stations, tire dealers)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('===========================================');
        $this->info('  OpenStreetMap Location Import - Germany  ');
        $this->info('===========================================');
        $this->newLine();

        $limit = $this->option('limit');
        $startTime = now();

        // Import workshops
        $this->info('📍 Step 1/3: Importing Workshops');
        $this->line('----------------------------------------');
        $workshopsResult = Artisan::call('import:workshops', [
            '--limit' => $limit,
        ], $this->getOutput());

        if ($workshopsResult !== Command::SUCCESS) {
            $this->error('Workshop import failed. Continuing with other imports...');
        }

        $this->newLine(2);

        // Import TÜV stations
        $this->info('📍 Step 2/3: Importing TÜV Stations');
        $this->line('----------------------------------------');
        $tuvResult = Artisan::call('import:tuv', [
            '--limit' => $limit,
        ], $this->getOutput());

        if ($tuvResult !== Command::SUCCESS) {
            $this->error('TÜV import failed. Continuing with other imports...');
        }

        $this->newLine(2);

        // Import tire dealers
        $this->info('📍 Step 3/3: Importing Tire Dealers');
        $this->line('----------------------------------------');
        $tireDealersResult = Artisan::call('import:tire-dealers', [
            '--limit' => $limit,
        ], $this->getOutput());

        if ($tireDealersResult !== Command::SUCCESS) {
            $this->error('Tire dealer import failed.');
        }

        $this->newLine(2);

        // Overall summary
        $this->displayOverallSummary($startTime, $workshopsResult, $tuvResult, $tireDealersResult);

        // Return success only if all imports succeeded
        if ($workshopsResult === Command::SUCCESS &&
            $tuvResult === Command::SUCCESS &&
            $tireDealersResult === Command::SUCCESS) {
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    /**
     * Display overall import summary
     *
     * @param \Illuminate\Support\Carbon $startTime
     * @param int $workshopsResult
     * @param int $tuvResult
     * @param int $tireDealersResult
     * @return void
     */
    protected function displayOverallSummary($startTime, int $workshopsResult, int $tuvResult, int $tireDealersResult): void
    {
        $this->info('===========================================');
        $this->info('  Overall Import Summary                  ');
        $this->info('===========================================');
        $this->newLine();

        $duration = $startTime->diffInSeconds(now());
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;

        $this->table(
            ['Import Type', 'Status'],
            [
                ['Workshops', $workshopsResult === Command::SUCCESS ? '✓ Success' : '✗ Failed'],
                ['TÜV Stations', $tuvResult === Command::SUCCESS ? '✓ Success' : '✗ Failed'],
                ['Tire Dealers', $tireDealersResult === Command::SUCCESS ? '✓ Success' : '✗ Failed'],
            ]
        );

        $this->newLine();
        $this->info(sprintf('Total Duration: %dm %ds', $minutes, $seconds));

        // Get database statistics
        $this->displayDatabaseStatistics();
    }

    /**
     * Display database statistics
     *
     * @return void
     */
    protected function displayDatabaseStatistics(): void
    {
        $this->newLine();
        $this->info('Database Statistics:');

        $workshopCount = \App\Models\Location::workshops()->count();
        $tuvCount = \App\Models\Location::tuv()->count();
        $tireDealerCount = \App\Models\Location::tireDealers()->count();
        $totalCount = \App\Models\Location::count();

        $this->table(
            ['Location Type', 'Total Count'],
            [
                ['Workshops', $workshopCount],
                ['TÜV Stations', $tuvCount],
                ['Tire Dealers', $tireDealerCount],
                ['Total Locations', $totalCount],
            ]
        );

        // Recently synced
        $recentlySynced = \App\Models\Location::where('last_synced_at', '>=', now()->subHour())->count();
        $this->info(sprintf('Recently synced (last hour): %d locations', $recentlySynced));
    }
}
