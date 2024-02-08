<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Lounges\Models\Lounge;
use App\Filament\Resources\LoungeResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoungeResource extends Resource
{
    protected static ?string $model = Lounge::class;

    protected static ?string $modelLabel = 'Лаундж';

    protected static ?string $pluralModelLabel = 'Лаундж-зоны';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->relationship('filial', 'address')
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->numeric(),
                Forms\Components\TextInput::make('min_price')
                    ->label('Мин. цена')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Отображение на сайте')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\FileUpload::make('cover')
                    ->directory('lounge_images')
                    ->label('Изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filial.city.name')
                    ->label('Город')
                    ->sortable(),
                Tables\Columns\TextColumn::make('filial.address')
                    ->label('Адрес')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Отображение на сайте'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('filial.city', 'name'),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\ListLounges::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\CreateLounge::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\EditLounge::route('/{record}/edit'),
        ];
    }
}
