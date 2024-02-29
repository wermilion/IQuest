<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use App\Domain\Quests\Enums\LevelEnum;
use App\Domain\Quests\Models\Quest;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\CreateQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\EditQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\ListQuests;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\ViewQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestImagesRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekdaysSlotsRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekendSlotsRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Rules\LatinRule;
use Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    protected static ?string $modelLabel = 'Квест';

    protected static ?string $pluralModelLabel = 'Квесты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Select::make('filial')
                    ->label('Филиал')
                    ->live()
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Select::make('room_id')
                    ->label('Комната')
                    ->columnSpanFull()
                    ->options(fn(Get $get) => Room::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Select::make('type_id')
                    ->label('Тип')
                    ->relationship('type', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Select::make('genre_id')
                    ->label('Жанр')
                    ->relationship('genre', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Select::make('age_limit_id')
                    ->label('Ограничение')
                    ->relationship('age_limit', 'limit')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Select::make('level')
                    ->label('Уровень сложность')
                    ->options(LevelEnum::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(30)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                TextInput::make('slug')
                    ->label('Сокращ. название')
                    ->required()
                    ->maxLength(10)
                    ->rules([new LatinRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                Textarea::make('description')
                    ->autosize()
                    ->label('Описание')
                    ->required()
                    ->maxLength(1000)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                Textarea::make('short_description')
                    ->autosize()
                    ->label('Краткое описание')
                    ->required()
                    ->maxLength(125)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                TextInput::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->live()
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно 1.'
                    ]),
                TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->numeric()
                    ->minValue(fn(Get $get) => $get('min_people'))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно полю "Мин. кол-во человек".'
                    ]),
                TextInput::make('duration')
                    ->label('Продолжительность (в мин)')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                FileUpload::make('cover')
                    ->label('Обложка')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.'
                    ]),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Квесты не обнаружены')
            ->columns([
                TextColumn::make('room.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('room.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Сокращ. название')
                    ->searchable(),
                TextColumn::make('type.name')
                    ->label('Тип')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('genre.name')
                    ->label('Жанр')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('age_limit.limit')
                    ->label('Возрастное ограничение')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('level')
                    ->label('Уровень сложности')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('duration')
                    ->label('Продолжительность')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->numeric()
                    ->sortable(),
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
                            ->relationship('filial.city', 'name')
                            ->native(false),
                        Select::make('filial_id')
                            ->label('Филиал')
                            ->placeholder('Выберите филиал')
                            ->live()
                            ->options(fn(Get $get): Collection => Filial::query()
                                ->where('city_id', $get('city_id'))
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
                                    ->whereHas('room', fn(Builder $query): Builder => $query->where('filial_id', $filial_id)),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::where('id', $data['city_id'])
                                ->first()->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::where('id', $data['filial_id'])
                                ->first()->address;
                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Расписание', [
                QuestWeekdaysSlotsRelationManager::class,
                QuestWeekendSlotsRelationManager::class,
            ]),
            RelationGroup::make('Изображения', [
                QuestImagesRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuests::route('/'),
            'create' => CreateQuest::route('/create'),
            'edit' => EditQuest::route('/{record}/edit'),
            'view' => ViewQuest::route('/{record}'),
        ];
    }
}
