<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                        'tuv' => 'TÜV',
                        'tire_dealer' => 'Tire Dealer',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('postal_code')
                    ->label('ZIP')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('state')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('street')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('latitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('longitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'workshop' => 'Workshop',
                        'tuv' => 'TÜV',
                        'tire_dealer' => 'Tire Dealer',
                    ])
                    ->multiple(),

                SelectFilter::make('city')
                    ->searchable()
                    ->preload()
                    ->relationship('location', 'city')
                    ->multiple(),

                SelectFilter::make('state')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('postal_code')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
