<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TagsInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class TireDealerDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'tireDealerDetail';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tire Dealer Details')
                    ->schema([
                        TagsInput::make('tire_brands')
                            ->label('Tire Brands')
                            ->placeholder('Add brand')
                            ->helperText('E.g., Michelin, Continental, Bridgestone, Pirelli'),

                        TagsInput::make('services')
                            ->placeholder('Add service')
                            ->helperText('E.g., mounting, storage, balancing, alignment'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('location.name')
            ->columns([
                TextColumn::make('tire_brands')
                    ->label('Tire Brands')
                    ->badge()
                    ->separator(','),

                TextColumn::make('services')
                    ->badge()
                    ->separator(','),
            ]);
    }

}
