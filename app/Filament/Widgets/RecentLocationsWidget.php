<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentLocationsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Location::query()
                    ->latest()
                    ->limit(10)
            )
            ->heading('Recently Added Locations')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'workshop',
                        'success' => 'tuv',
                        'warning' => 'tire_dealer',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'workshop' => 'Workshop',
                        'tuv' => 'TUV',
                        'tire_dealer' => 'Tire Dealer',
                        default => $state,
                    }),

                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
