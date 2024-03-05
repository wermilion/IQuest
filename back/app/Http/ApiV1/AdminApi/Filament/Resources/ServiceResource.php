<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Services\Models\Service;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages\CreateService;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages\EditService;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages\ListServices;
use App\Http\ApiV1\AdminApi\Filament\Rules\CyrillicRule;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $modelLabel = 'Доп. услуга';

    protected static ?string $pluralModelLabel = 'Доп. услуги';

    protected static ?string $navigationLabel = 'Доп. услуги';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

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
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLengthWithHint(20)
                    ->dehydrateStateUsing(fn ($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.',
                    ]),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('unit')
                    ->label('Единица измерения')
                    ->required()
                    ->rules([new CyrillicRule()])
                    ->maxLengthWithHint(20)
                    ->dehydrateStateUsing(fn ($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Услуги не обнаружены')
            ->columns([
                TextColumn::make('city.name')
                    ->label('Город'),
                TextColumn::make('name')
                    ->label('Название'),
                TextColumn::make('price')
                    ->label('Цена'),
                TextColumn::make('unit')
                    ->label('Единица измерения'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                ViewAction::make()->modalHeading('Просмотр услуги'),
                DeleteAction::make()->modalHeading('Удаление услуги'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
