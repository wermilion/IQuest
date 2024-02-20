<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingHoliday;
use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingHolidayResource extends Resource
{
    protected static ?string $model = BookingHoliday::class;

    protected static ?string $modelLabel = 'Заявка на праздник';

    protected static ?string $pluralModelLabel = 'Заявки на праздники';

    protected static ?string $navigationLabel = 'Заявки на праздники';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('booking_id')
                    ->label('ID бронирования')
                    ->options(fn() => Booking::query()
                        ->where('type', BookingType::HOLIDAY->getLabel())
                        ->withoutTrashed()
                        ->pluck('id', 'id'))
                    ->searchable()
                    ->native(false),
                Select::make('holiday')
                    ->label('Тип праздника')
                    ->live()
                    ->options(fn() => Holiday::all()->pluck('type.value', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->native(false),
                Select::make('package')
                    ->label('Пакет')
                    ->live()
                    ->options(fn(Get $get) => Holiday::query()
                        ->find($get('holiday'))
                        ?->packages
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->native(false),
                TextInput::make('count_participants')
                    ->label('Количество участников')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше нуля.',
                        'numeric' => 'Поле ":attribute" должно быть числом.',
                    ]),
                TextInput::make('price')
                    ->label('Стоимость')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше нуля.',
                        'numeric' => 'Поле ":attribute" должно быть числом.',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('booking.name')
                    ->label('Имя'),
                Tables\Columns\TextColumn::make('booking.phone')
                    ->label('Телефон'),
                Tables\Columns\TextColumn::make('holidayPackage.holiday.type')
                    ->label('Тип праздника'),
                Tables\Columns\TextColumn::make('holidayPackage.package.name')
                    ->label('Пакет'),
                Tables\Columns\TextColumn::make('count_participants')
                    ->label('Количество участников'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Стоимость'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
            ])
            ->emptyStateHeading('Заявок на праздники не обнаружено');
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
            'index' => Pages\ListBookingHolidays::route('/'),
            'create' => Pages\CreateBookingHoliday::route('/create'),
            'edit' => Pages\EditBookingHoliday::route('/{record}/edit'),
        ];
    }
}
