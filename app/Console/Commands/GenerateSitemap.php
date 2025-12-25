<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate
                            {--output=public/sitemap.xml : The output path for the sitemap}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for all published content including locations and posts';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // Add homepage
        $sitemap->add(
            Url::create(route('home'))
                ->setLastModificationDate(now())
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Add locations index
        $sitemap->add(
            Url::create(route('locations.index'))
                ->setLastModificationDate(now())
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Add all locations
        $this->info('Adding locations...');
        Location::query()
            ->chunk(100, function ($locations) use ($sitemap) {
                foreach ($locations as $location) {
                    $sitemap->add(
                        Url::create(route('locations.show', ['slug' => $location->slug]))
                            ->setLastModificationDate($location->updated_at)
                            ->setPriority(0.7)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }
            });

        // Add blog index
        $sitemap->add(
            Url::create(route('posts.index'))
                ->setLastModificationDate(now())
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Add all published posts
        $this->info('Adding blog posts...');
        Post::query()
            ->published()
            ->chunk(100, function ($posts) use ($sitemap) {
                foreach ($posts as $post) {
                    $sitemap->add(
                        Url::create(route('posts.show', ['slug' => $post->slug]))
                            ->setLastModificationDate($post->updated_at)
                            ->setPriority(0.8)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }
            });

        // Get output path
        $outputPath = $this->option('output');
        $fullPath = base_path($outputPath);

        // Write sitemap
        $sitemap->writeToFile($fullPath);

        $this->info("Sitemap generated successfully at: {$outputPath}");

        return self::SUCCESS;
    }
}
