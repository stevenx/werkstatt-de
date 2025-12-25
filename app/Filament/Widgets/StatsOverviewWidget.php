<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Locations', Location::count())
                ->description('All registered locations')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Workshops', Location::where('type', 'workshop')->count())
                ->description('Workshop locations')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('primary'),

            Stat::make('TUV Stations', Location::where('type', 'tuv')->count())
                ->description('TUV inspection centers')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),

            Stat::make('Tire Dealers', Location::where('type', 'tire_dealer')->count())
                ->description('Tire dealer locations')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('info'),

            Stat::make('Published Posts', Post::whereNotNull('published_at')->where('published_at', '<=', now())->count())
                ->description('Live blog posts')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Draft Posts', Post::whereNull('published_at')->orWhere('published_at', '>', now())->count())
                ->description('Unpublished posts')
                ->descriptionIcon('heroicon-m-document')
                ->color('gray'),
        ];
    }
}
