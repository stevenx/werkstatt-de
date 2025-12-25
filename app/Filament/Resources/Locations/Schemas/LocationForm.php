<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\KeyValue;
use Filament\Schemas\Components\DateTimePicker;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Basic Information')
                            ->schema([
                                Section::make('Location Details')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) =>
                                                $set('slug', \Illuminate\Support\Str::slug($state))
                                            ),

                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),

                                        Select::make('type')
                                            ->options([
                                                'workshop' => 'Workshop',
                                                'tuv' => 'TÜV',
                                                'tire_dealer' => 'Tire Dealer',
                                            ])
                                            ->required()
                                            ->native(false),
                                    ])
                                    ->columns(2),

                                Section::make('Address Information')
                                    ->schema([
                                        TextInput::make('street')
                                            ->maxLength(255),

                                        TextInput::make('house_number')
                                            ->maxLength(255),

                                        TextInput::make('postal_code')
                                            ->maxLength(255),

                                        TextInput::make('city')
                                            ->maxLength(255),

                                        TextInput::make('state')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Contact & Location')
                            ->schema([
                                Section::make('Contact Information')
                                    ->schema([
                                        TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(255),

                                        TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),

                                        TextInput::make('website')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),

                                Section::make('Geographic Coordinates')
                                    ->schema([
                                        TextInput::make('latitude')
                                            ->numeric()
                                            ->step(0.0000001)
                                            ->minValue(-90)
                                            ->maxValue(90),

                                        TextInput::make('longitude')
                                            ->numeric()
                                            ->step(0.0000001)
                                            ->minValue(-180)
                                            ->maxValue(180),
                                    ])
                                    ->columns(2)
                                    ->description('Enter the latitude and longitude coordinates for map display'),
                            ]),

                        Tab::make('Additional Details')
                            ->schema([
                                Section::make('Opening Hours')
                                    ->schema([
                                        KeyValue::make('opening_hours')
                                            ->keyLabel('Day')
                                            ->valueLabel('Hours')
                                            ->reorderable(false),
                                    ]),

                                Section::make('OpenStreetMap Sync')
                                    ->schema([
                                        TextInput::make('osm_id')
                                            ->label('OSM ID')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255),

                                        TextInput::make('osm_type')
                                            ->label('OSM Type')
                                            ->maxLength(255)
                                            ->placeholder('node, way, or relation'),

                                        DateTimePicker::make('last_synced_at')
                                            ->label('Last Synced At')
                                            ->disabled(),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
