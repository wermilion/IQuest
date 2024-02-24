<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages\ListBookingScheduleLounges;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookingScheduleLoungeResource extends Resource
{
    protected static ?string $model = BookingScheduleLounge::class;

    protected static ?string $modelLabel = 'Заявка на лаунж-зону';

    protected static ?string $pluralModelLabel = 'Заявки на лаунж-зоны';

    protected static ?string $navigationLabel = 'Заявки на лаунж-зоны';

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
            ->emptyStateHeading('Заявок на лаунж-зоны не обнаружено')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('booking.name')
                    ->label('Имя')
                    ->numeric(),
                TextColumn::make('booking.phone')
                    ->label('Телефон')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('scheduleLounge.lounge.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.lounge.filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.lounge.name')
                    ->label('Лаунж-зона')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.date')
                    ->label('Дата')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.time_from')
                    ->label('Время начала')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scheduleLounge.time_to')
                    ->label('Время конца')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
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
            ->actions([
                DeleteAction::make()->modalHeading('Удаление заявки'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingScheduleLounges::route('/'),
        ];
    }
}
