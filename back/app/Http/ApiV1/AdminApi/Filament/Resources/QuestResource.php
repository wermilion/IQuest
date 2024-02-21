<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use App\Domain\Quests\Models\Quest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\CreateQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\EditQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\ListQuests;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestImagesRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekdaysSlotsRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekendSlotsRelationManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Forms\Components\Select::make('filial')
                    ->label('Филиал')
                    ->live()
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Forms\Components\Select::make('room_id')
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
                Forms\Components\Select::make('type_id')
                    ->label('Тип')
                    ->relationship('type', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Forms\Components\Select::make('genre_id')
                    ->label('Жанр')
                    ->relationship('genre', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Forms\Components\Select::make('age_limit_id')
                    ->label('Ограничение')
                    ->relationship('age_limit', 'limit')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Forms\Components\Select::make('level_id')
                    ->label('Уровень сложность')
                    ->relationship('level', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('Сокращ. название')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\Textarea::make('short_description')
                    ->label('Краткое описание')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->live()
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->numeric(),
                Forms\Components\TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->numeric()
                    ->minValue(fn(Get $get) => $get('min_people'))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно полю "Мин. кол-во человек".'
                    ])
                    ->numeric(),
                Forms\Components\TextInput::make('duration')
                    ->label('Продолжительность (в мин)')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->numeric(),
                Forms\Components\TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->numeric(),
                Forms\Components\FileUpload::make('cover')
                    ->directory('quest_covers')
                    ->label('Обложка')
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.'
                    ]),
                Forms\Components\Toggle::make('is_active')
                    ->columnSpanFull()
                    ->label('Отображение на сайте')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('room.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Сокращ. название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->label('Тип')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('genre.name')
                    ->label('Жанр')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('age_limit.id')
                    ->label('Возрастное ограничение')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Уровень сложности')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('min_price')
                    ->label('Минимальная цена')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('late_price')
                    ->label('Вечерняя цена')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Продолжительность')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('can_add_time')
                    ->label('Можно ли добавить время')
                    ->boolean()
                    ->hidden(),
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
                Tables\Filters\Filter::make('location')
                    ->form([
                        Forms\Components\Select::make('city_id')
                            ->label('Город')
                            ->placeholder('Выберите город')
                            ->relationship('filial.city', 'name')
                            ->native(false),
                        Forms\Components\Select::make('filial_id')
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
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
            ])
            ->emptyStateHeading('Квесты не обнаружены');
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
        ];
    }
}
