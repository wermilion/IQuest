<?php

namespace App\Filament\Resources;

use App\Enums\NavigationGroup;
use App\Filament\Resources\ScheduleLoungeResource\Pages;
use App\Filament\Resources\ScheduleLoungeResource\RelationManagers;
use App\Models\City;
use App\Models\Filial;
use App\Models\ScheduleLounge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('filial')
                    ->label('Адрес')
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('lounge_id')
                    ->label('Лаундж-зона')
                    ->relationship('lounge', 'name')
                    ->required(),
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
                Tables\Filters\SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('lounge.filial.city', 'name'),
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
            'index' => Pages\ListScheduleLounges::route('/'),
            'create' => Pages\CreateScheduleLounge::route('/create'),
            'edit' => Pages\EditScheduleLounge::route('/{record}/edit'),
        ];
    }
}
