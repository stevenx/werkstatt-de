<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TagsInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class WorkshopDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'workshopDetail';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Workshop Details')
                    ->schema([
                        TagsInput::make('specializations')
                            ->placeholder('Add specialization')
                            ->helperText('E.g., brakes, tires, inspection, oil change'),

                        TagsInput::make('brands_serviced')
                            ->label('Brands Serviced')
                            ->placeholder('Add brand')
                            ->helperText('E.g., VW, Audi, BMW, Mercedes'),

                        TagsInput::make('services')
                            ->placeholder('Add service')
                            ->helperText('E.g., general repair, tire service, inspection'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('location.name')
            ->columns([
                TextColumn::make('specializations')
                    ->badge()
                    ->separator(','),

                TextColumn::make('brands_serviced')
                    ->label('Brands')
                    ->badge()
                    ->separator(','),

                TextColumn::make('services')
                    ->badge()
                    ->separator(','),
            ]);
    }

}
