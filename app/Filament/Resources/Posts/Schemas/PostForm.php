<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\RichEditor;
use Filament\Schemas\Components\FileUpload;
use Filament\Schemas\Components\DateTimePicker;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Post Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', \Illuminate\Support\Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from title'),

                        Textarea::make('excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Short description of the post'),

                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('post-attachments')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'strike',
                                'link',
                                'heading',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'table',
                                'undo',
                                'redo',
                            ]),
                    ])
                    ->columnSpan(2),

                Section::make('Post Details')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('featured-images')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),

                        Select::make('author_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Published Date')
                            ->helperText('Leave empty to save as draft'),

                        Toggle::make('is_featured')
                            ->label('Featured Post')
                            ->default(false),
                    ])
                    ->columnSpan(1),

                Section::make('SEO Settings')
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(60)
                            ->helperText('Recommended: 50-60 characters'),

                        Textarea::make('meta_description')
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText('Recommended: 150-160 characters'),

                        TextInput::make('meta_keywords')
                            ->helperText('Comma-separated keywords'),
                    ])
                    ->columnSpan(2)
                    ->collapsible(),
            ]);
    }
}
