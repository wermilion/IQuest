<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookingScheduleLoungeResource extends Resource
{
    protected static ?string $model = BookingScheduleLounge::class;

    protected static ?string $modelLabel = 'Заявка на лаундж-зону';

    protected static ?string $pluralModelLabel = 'Заявки на лаундж-зоны';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Tables\Columns\TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking.name')
                    ->label('Имя')
                    ->numeric(),
                Tables\Columns\TextColumn::make('booking.phone')
                    ->label('Телефон')
                    ->numeric()
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduleLounge.lounge.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleLounge.lounge.filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleLounge.lounge.name')
                    ->label('Лаундж-зона')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleLounge.date')
                    ->label('Дата')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleLounge.time_from')
                    ->label('Время начала')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('scheduleLounge.time_to')
                    ->label('Время конца')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
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
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
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
            'index' => Pages\ListBookingScheduleLounges::route('/'),
            'create' => Pages\CreateBookingScheduleLounge::route('/create'),
            'edit' => Pages\EditBookingScheduleLounge::route('/{record}/edit'),
        ];
    }
}
