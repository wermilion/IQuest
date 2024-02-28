<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingHoliday;
use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\CreateBookingHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\EditBookingHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\ListBookingHolidays;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingHolidayResource extends Resource
{
    protected static ?string $model = BookingHoliday::class;

    protected static ?string $modelLabel = 'Заявка на праздник';

    protected static ?string $pluralModelLabel = 'Заявки на праздники';

    protected static ?string $navigationLabel = 'Заявки на праздники';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('booking_id')
                    ->label('ID бронирования')
                    ->relationship('booking',
                        'id',
                        fn(Builder $query): Builder => $query
                            ->where('type', BookingType::HOLIDAY->value)
                            ->whereDoesntHave('bookingHoliday'))
                    ->searchable()
                    ->native(false),
                TextInput::make('comment')
                    ->label('Комментарий')
                    ->maxLength(255),
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
                    ->options(fn(Get $get) => Holiday::query()
                        ->find($get('holiday'))
                        ?->packages
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявок на праздники не обнаружено')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID'),
                TextColumn::make('booking.name')
                    ->label('Имя'),
                TextColumn::make('booking.phone')
                    ->label('Телефон'),
                TextColumn::make('holidayPackage.holiday.type')
                    ->label('Тип праздника'),
                TextColumn::make('holidayPackage.package.name')
                    ->label('Пакет'),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление заявки'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingHolidays::route('/'),
            'create' => CreateBookingHoliday::route('/create'),
            'edit' => EditBookingHoliday::route('/{record}/edit'),
        ];
    }
}
