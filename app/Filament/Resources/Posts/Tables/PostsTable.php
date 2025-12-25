<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->toggleable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                TextColumn::make('author.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('published_at')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->getStateUsing(fn ($record) => $record->published_at !== null && $record->published_at->lte(now()))
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Draft'),

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
                TernaryFilter::make('published')
                    ->label('Published Status')
                    ->placeholder('All posts')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('published_at')->where('published_at', '<=', now()),
                        false: fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '>', now()),
                    ),

                SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All posts')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
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
