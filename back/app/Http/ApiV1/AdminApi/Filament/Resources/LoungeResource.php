<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Lounges\Models\Lounge;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\CreateLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\EditLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\ListLounges;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages\ViewLounge;
use Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoungeResource extends Resource
{
    protected static ?string $model = Lounge::class;

    protected static ?string $modelLabel = 'Лаунж';

    protected static ?string $pluralModelLabel = 'Лаунжи';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->label('Город')
                    ->placeholder('Выберите город')
                    ->live()
                    ->relationship('filial.city', 'name')
                    ->afterStateUpdated(function ($state, Select $component) {
                        $component->getContainer()
                            ->getComponent('filial')
                            ->state(null)
                            ->options(fn() => Filial::where('city_id', $state)->pluck('address', 'id'));
                    })
                    ->hiddenOn('')
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                Select::make('filial_id')
                    ->key('filial')
                    ->label('Филиал')
                    ->placeholder('Выберите филиал')
                    ->options(fn(Get $get) => Filial::where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return City::exists() ? '' : 'Филиалы не обнаружены. Сначала создайте филиалы.';
                    })
                    ->native(false),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Textarea::make('description')
                    ->autosize()
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLengthWithHint(1000)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('price_per_half_hour')
                    ->label('Цена за половину часа')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('price_per_hour')
                    ->label('Цена за час')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                FileUpload::make('cover')
                    ->directory('lounge_images')
                    ->label('Изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Лаунжи не обнаружены')
            ->columns([
                TextColumn::make('filial.city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('filial.address')
                    ->label('Филиал')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->disabled(Auth::user()->role !== Role::ADMIN),
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
                Filter::make('location')
                    ->form([
                        Select::make('city_id')
                            ->label('Город')
                            ->placeholder('Выберите город')
                            ->live()
                            ->relationship('filial.city', 'name')
                            ->afterStateUpdated(function ($state, Select $component) {
                                $component->getContainer()
                                    ->getComponent('filial')
                                    ->state(null)
                                    ->options(fn() => Filial::where('city_id', $state)->pluck('address', 'id'));
                            })
                            ->native(false),
                        Select::make('filial_id')
                            ->key('filial')
                            ->label('Филиал')
                            ->placeholder('Выберите филиал')
                            ->options(fn(Get $get) => Filial::where('city_id', $get('city_id'))
                                ->pluck('address', 'id'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn(Builder $query, $city_id): Builder => $query
                                    ->whereHas('filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->where('filial_id', $filial_id),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::where('id', $data['city_id'])
                                ->first()->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::where('id', $data['filial_id'])
                                ->first()->address;
                        return $indicators;
                    })
                    ->columnSpan(2)->columns(2),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление лаунжа'),
                ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLounges::route('/'),
            'create' => CreateLounge::route('/create'),
            'edit' => EditLounge::route('/{record}/edit'),
            'view' => ViewLounge::route('/{record}'),
        ];
    }
}
