<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\BookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\CreateBookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\EditBookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\ListBookingCertificates;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
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

class BookingCertificateResource extends Resource
{
    protected static ?string $model = BookingCertificate::class;

    protected static ?string $modelLabel = 'Заявка на сертификат';

    protected static ?string $pluralModelLabel = 'Заявки на сертификаты';

    protected static ?string $navigationLabel = 'Заявки на сертификаты';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('booking_id')
                    ->label('ID заявки')
                    ->placeholder('Выберите ID заявки')
                    ->live()
                    ->relationship('booking',
                        'id',
                        fn(Builder $query): Builder => $query
                            ->where('type', BookingType::CERTIFICATE->value)
                            ->whereDoesntHave('bookingCertificate'))
                    ->searchable()
                    ->native(false),
                Select::make('certificate_type_id')
                    ->label('Тип сертификата')
                    ->placeholder('Выберите тип сертификата')
                    ->relationship('certificateType', 'name')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявки на сертификаты не обнаружены')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.name')
                    ->label('Имя'),
                TextColumn::make('booking.phone')
                    ->label('Телефон'),
                TextColumn::make('certificateType.name')
                    ->label('Типа сертификата'),
                TextColumn::make('created_at')
                    ->label('Дата заявки')
                    ->date(),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип сертификата')
                    ->relationship('certificateType', 'name')
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
            'index' => ListBookingCertificates::route('/'),
            'create' => CreateBookingCertificate::route('/create'),
            'edit' => EditBookingCertificate::route('/{record}/edit'),
        ];
    }
}
