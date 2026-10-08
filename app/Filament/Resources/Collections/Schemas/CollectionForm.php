<?php

namespace App\Filament\Resources\Collections\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            SpatieMediaLibraryFileUpload::make('cover')
                ->collection('cover')
                ->disk('public')
                ->visibility('public')
                ->image()
                ->helperText('Portrait photos (4:5) look best. If left empty, the newest product photo is used.')
                ->columnSpanFull(),
            TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Textarea::make('description')
                ->columnSpanFull(),
            TextInput::make('sort_order')
                ->numeric()
                ->default(0),
        ]);
    }
}