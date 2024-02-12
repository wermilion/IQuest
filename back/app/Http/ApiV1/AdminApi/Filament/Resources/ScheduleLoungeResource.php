<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Lounges\Models\Lounge;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Filament\Resources\ScheduleLoungeResource\Pages;
use App\Filament\Resources\ScheduleLoungeResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\CreateScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\EditScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\ListScheduleLounges;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\RelationManagers\BookingRelationManager;
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

class ScheduleLoungeResource extends Resource
{
    protected static ?string $model = ScheduleLounge::class;

    protected static ?string $modelLabel = 'Слот расписания лаундж-зоны';

    protected static ?string $pluralModelLabel = 'Расписание лаундж-зон';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::SCHEDULE->value;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn(): Collection => City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Forms\Components\Select::make('filial')
                    ->label('Адрес')
                    ->live()
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->native(false),
                Forms\Components\Select::make('lounge_id')
                    ->label('Лаундж-зона')
                    //->relationship('lounge', 'name')
                    ->options(fn(Get $get): Collection => Lounge::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('date')
                    ->label('Дата')
                    ->required(),
                Forms\Components\TextInput::make('time_from')
                    ->label('Время начала')
                    ->mask('99:99')
                    ->placeholder('xx:xx')
                    ->required(),
                Forms\Components\TextInput::make('time_to')
                    ->label('Время конца')
                    ->mask('99:99')
                    ->placeholder('xx:xx')
                    ->required(),
            ]);
    }

    public static function canDelete(Model $record): bool
    {
        return !($record->booking()->exists());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lounge.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lounge.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lounge.name')
                    ->label('Лаундж-зона')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_from')
                    ->label('Время начала'),
                Tables\Columns\TextColumn::make('time_to')
                    ->label('Время конца'),
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
                            ->relationship('lounge.filial.city', 'name')
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
                                    ->whereHas('lounge.filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->whereHas('lounge.filial', fn(Builder $query): Builder => $query->where('id', $filial_id)),
                            );
                    }),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookingRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScheduleLounges::route('/'),
            'create' => CreateScheduleLounge::route('/create'),
            'edit' => EditScheduleLounge::route('/{record}/edit'),
        ];
    }
}
