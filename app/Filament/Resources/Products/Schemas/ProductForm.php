<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            SpatieMediaLibraryFileUpload::make('gallery')
                ->collection('gallery')
                ->disk('public')
                ->visibility('public')
                ->multiple()
                ->reorderable()
                ->image()
                ->columnSpanFull(),
            TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Select::make('collection_id')
                ->relationship('collection', 'name')
                ->searchable()
                ->preload(),
            Textarea::make('description')
                ->columnSpanFull(),
            TextInput::make('price')
                ->numeric()
                ->required()
                ->prefix('PKR'),
            TextInput::make('compare_at_price')
                ->numeric()
                ->prefix('PKR'),
            TextInput::make('stock')
                ->numeric()
                ->default(1),
            Toggle::make('is_active')
                ->label('Visible in store'),
        ]);
    }
}