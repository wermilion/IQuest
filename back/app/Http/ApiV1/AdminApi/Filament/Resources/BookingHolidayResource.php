<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\BookingHoliday;
use App\Domain\Holidays\Models\Package;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\CreateBookingHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\EditBookingHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages\ListBookingHolidays;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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
                    ->label('ID заявки')
                    ->placeholder('Выберите ID заявки')
                    ->relationship('booking',
                        'id',
                        fn(Builder $query): Builder => $query
                            ->where('type', BookingType::HOLIDAY->value)
                            ->whereDoesntHave('bookingHoliday'))
                    ->searchable()
                    ->native(false),
                TextInput::make('comment')
                    ->label('Комментарий')
                    ->maxLengthWithHint(255),
                Select::make('holiday')
                    ->label('Тип праздника')
                    ->placeholder('Выберите тип праздника')
                    ->live()
                    ->relationship(
                        'holidayPackage.holiday',
                        'type',
                        fn(Builder $query): Builder => $query->where('is_active', true)
                    )
                    ->afterStateUpdated(function ($state, Select $component) {
                        $component->getContainer()
                            ->getComponent('package')
                            ->state(null)
                            ->options(fn() => Package::whereHas('holidayPackages', fn(Builder $query) => $query->where('holiday_id', $state))
                                ->pluck('name', 'id'));
                    })
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->native(false),
                Select::make('package')
                    ->key('package')
                    ->label('Пакет')
                    ->placeholder('Выберите пакет')
                    ->options(fn(Get $get) => Package::whereHas('holidayPackages', fn(Builder $query) => $query->where('holiday_id', $get('holiday')))
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return Package::exists() ? '' : 'Пакеты не обнаружены. Сначала создайте пакеты.';
                    })
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявок на праздники не обнаружено')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('booking.name')
                    ->label('Имя'),
                TextColumn::make('booking.phone')
                    ->label('Телефон'),
                TextColumn::make('holidayPackage.holiday.type')
                    ->label('Тип праздника')
                    ->sortable(),
                TextColumn::make('holidayPackage.package.name')
                    ->label('Пакет')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата заявки')
                    ->date(),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('booking.city', 'name')
                    ->native(false),
                Filter::make('date')
                    ->form([DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], fn($query, $date) => $query
                            ->whereDate('created_at', $date));
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        $data['date'] && $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->translatedFormat('M j, y');
                        return $indicators;
                    })
            ], layout: FiltersLayout::AboveContentCollapsible)
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
