<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Sales\Models\Sale;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $modelLabel = 'Акция';

    protected static ?string $pluralModelLabel = 'Акции';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->native(false),
                TextInput::make('header')
                    ->label('Заголовок')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('description')
                    ->label('Описание')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                FileUpload::make('front_image')
                    ->directory('sales')
                    ->label('Переднее изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ]),
                FileUpload::make('back_image')
                    ->directory('sales')
                    ->label('Заднее изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ]),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Акции не обнаружены')
            ->columns([
                TextColumn::make('city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('header')
                    ->label('Заголовок'),
                TextColumn::make('description')
                    ->label('Описание'),
                ToggleColumn::make('is_active')
                    ->label('Отображение на сайте'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('city_id')
            ->filters([
                SelectFilter::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удалить акцию')
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
