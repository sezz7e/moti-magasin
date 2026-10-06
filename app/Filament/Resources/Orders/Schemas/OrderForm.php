<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')->options([
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled',
            ])->required(),
            TextInput::make('order_number')->disabled(),
            TextInput::make('customer_name')->disabled(),
            TextInput::make('phone')->disabled(),
            TextInput::make('city')->disabled(),
            Textarea::make('address')->disabled()->columnSpanFull(),
            Textarea::make('notes')->disabled()->columnSpanFull(),
            TextInput::make('total')->prefix('PKR')->disabled(),
            Repeater::make('items')
                ->relationship()
                ->schema([
                    TextInput::make('product_name')->disabled(),
                    TextInput::make('quantity')->disabled(),
                    TextInput::make('price')->prefix('PKR')->disabled(),
                ])
                ->columns(3)
                ->addable(false)
                ->deletable(false)
                ->reorderable(false)
                ->columnSpanFull(),
        ]);
    }
}