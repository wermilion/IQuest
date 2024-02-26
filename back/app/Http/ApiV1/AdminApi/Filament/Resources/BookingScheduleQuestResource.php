<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages\ListBookingScheduleQuests;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookingScheduleQuestResource extends Resource
{
    protected static ?string $model = BookingScheduleQuest::class;

    protected static ?string $modelLabel = 'Заявка на квест';

    protected static ?string $pluralLabel = 'Заявки на квесты';

    protected static ?string $navigationLabel = 'Заявки на квесты';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 2;

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
            ->emptyStateHeading('Заявки на квесты не обнаружены')
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
                TextColumn::make('timeslot.scheduleQuest.quest.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.quest.filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.quest.name')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.date')
                    ->label('Дата')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.time')
                    ->label('Время')
                    ->numeric(),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListBookingScheduleQuests::route('/'),
        ];
    }
}
