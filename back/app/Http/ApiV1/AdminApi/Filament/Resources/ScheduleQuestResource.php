<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Filament\Resources\ScheduleQuestResource\Pages;
use App\Filament\Resources\ScheduleQuestResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ScheduleQuestResource extends Resource
{
    protected static ?string $model = ScheduleQuest::class;

    protected static ?string $modelLabel = 'Слот расписания квеста';

    protected static ?string $pluralModelLabel = 'Расписание квестов';

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
                    ->hiddenOn(''),
                Forms\Components\Select::make('filial')
                    ->label('Адрес')
                    ->live()
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('room')
                    ->label('Комната')
                    ->live()
                    ->options(fn(Get $get): Collection => Room::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->hiddenOn(''),
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
                    ]),
                Forms\Components\DatePicker::make('date')
                    ->label('Дата')
                    ->live()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\Select::make('time')
                    ->label('Время')
                    ->options(function (Get $get) {
                        return is_weekend($get('date')) ?
                            Quest::query()->where('id', $get('quest_id'))->first()?->weekend :
                            Quest::query()->where('id', $get('quest_id'))->first()?->weekdays;
                    })
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\Toggle::make('activity_status')
                    ->label('Активность слота')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
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
                Tables\Columns\TextColumn::make('quest.name')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Время'),
                Tables\Columns\IconColumn::make('activity_status')
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
                Tables\Filters\SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('quest.room.filial.city', 'name'),
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
                            $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->locale('ru')->format('M j, Y');
                        }
                        return $indicators;
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\ListScheduleQuests::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\CreateScheduleQuest::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages\EditScheduleQuest::route('/{record}/edit'),
        ];
    }
}
