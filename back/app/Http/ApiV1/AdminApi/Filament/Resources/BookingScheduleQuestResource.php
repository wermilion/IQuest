<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages\CreateBookingScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages\EditBookingScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages\ListBookingScheduleQuests;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BookingScheduleQuestResource extends Resource
{
    protected static ?string $model = BookingScheduleQuest::class;

    protected static ?string $modelLabel = 'Квест';

    protected static ?string $pluralLabel = 'Квесты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('scheduleQuest.quest.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleQuest.quest.filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleQuest.quest.name')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleQuest.date')
                    ->label('Дата')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduleQuest.time')
                    ->label('Время')
                    ->numeric(),
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
            'index' => ListBookingScheduleQuests::route('/'),
            'create' => CreateBookingScheduleQuest::route('/create'),
            'edit' => EditBookingScheduleQuest::route('/{record}/edit'),
        ];
    }
}
