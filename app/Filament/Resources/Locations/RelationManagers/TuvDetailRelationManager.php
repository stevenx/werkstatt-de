<?php

namespace App\Filament\Resources\Locations\RelationManagers;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TagsInput;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class TuvDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'tuvDetail';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('TÜV Station Details')
                    ->schema([
                        TagsInput::make('inspection_types')
                            ->placeholder('Add inspection type')
                            ->helperText('E.g., main inspection, emissions test, safety check'),

                        \Filament\Schemas\Components\Toggle::make('appointment_required')
                            ->label('Appointment Required')
                            ->default(false),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('location.name')
            ->columns([
                TextColumn::make('inspection_types')
                    ->badge()
                    ->separator(','),

                \Filament\Tables\Columns\IconColumn::make('appointment_required')
                    ->label('Appointment Required')
                    ->boolean(),
            ]);
    }

}
