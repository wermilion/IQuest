<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\CreateScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\EditScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\ListScheduleQuests;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\RelationManagers\BookingRelationManager;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ScheduleQuestResource extends Resource
{
    protected static ?string $model = ScheduleQuest::class;

    protected static ?string $modelLabel = 'Слот расписания квеста';

    protected static ?string $pluralModelLabel = 'Расписание квестов';

    protected static ?string $navigationLabel = 'Расписание квестов';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::SCHEDULE->value;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->disabledOn('edit'),
                Forms\Components\Select::make('filial')
                    ->label('Адрес')
                    ->live()
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->disabledOn('edit'),
                Forms\Components\Select::make('room')
                    ->label('Комната')
                    ->live()
                    ->options(fn(Get $get): Collection => Room::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->disabledOn('edit'),
                Forms\Components\Select::make('quest_id')
                    ->label('Квест')
                    ->relationship('quest', 'name')
                    ->options(fn(Get $get) => Quest::query()
                        ->where('room_id', $get('room'))
                        ->pluck('name', 'id'))
                    ->live()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                Forms\Components\DatePicker::make('date')
                    ->label('Дата')
                    ->live()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('time')
                    ->label('Время')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                Forms\Components\Toggle::make('activity_status')
                    ->label('Активность слота')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quest.room.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quest.room.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quest.slug')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Время'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена'),
                Tables\Columns\ToggleColumn::make('activity_status')
                    ->label('Активность слота'),
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
                            ->relationship('quest.filial.city', 'name')
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
                                    ->whereHas('quest.filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->whereHas('quest.room', fn(Builder $query): Builder => $query->where('filial_id', $filial_id)),
                            );
                    }),
                Tables\Filters\SelectFilter::make('name')
                    ->relationship('quest', 'slug')
                    ->label('Квест')
                    ->native(false),
                Tables\Filters\Filter::make('date')
                    ->form([Forms\Components\DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'],
                            fn(Builder $query, $date): Builder => $query->whereDate('date', '=', $date)
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['date']) {
                            $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->translatedFormat('M j, Y');
                        }
                        return $indicators;
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ])
            ->emptyStateHeading('Слоты не обнаружены');
    }

    public static function getRelations(): array
    {
        return [
            BookingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScheduleQuests::route('/'),
            'create' => CreateScheduleQuest::route('/create'),
            'edit' => EditScheduleQuest::route('/{record}/edit'),
        ];
    }
}
