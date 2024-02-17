<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $label = 'Заказ';

    protected static ?string $pluralLabel = 'Заказы';
    protected static ?string $slug = 'orders';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    TextInput::make('id'),
                    TextInput::make('comment')
                        ->label('Комментарий'),
                    TextInput::make('cost')
                        ->label('Стоимость'),
                    TextInput::make('receipt_time')
                        ->label('Время доставки'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('comment')
                    ->label('Комментарий'),
                TextColumn::make('cost')
                    ->label('Стоимость'),
                TextColumn::make('receipt_time')
                    ->label('Время доставки'),
                TextColumn::make('customer.phone')->label('Телефон'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
