<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\CreateBooking;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = 'Все заявки';

    protected static ?string $modelLabel = 'Заявка';

    protected static ?string $pluralModelLabel = 'Заявки';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->required()
                    ->rules(['size:18'])
                    ->mask('+7 (999) 999-99-99')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'size' => 'Поле ":attribute" должно содержать 18 символов.',
                    ]),
                Select::make('type')
                    ->label('Тип заявки')
                    ->options(BookingType::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false)
                    ->disabledOn('edit'),
                Select::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::NEW->getLabel())
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявки не обнаружены')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип заявки'),
                SelectColumn::make('status')
                    ->options(BookingStatus::class)
                    ->label('Статус заявки')
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
                TextColumn::make('deleted_at')
                    ->label('Дата удаления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->native(false),
                SelectFilter::make('type')
                    ->label('Тип заявки')
                    ->options(BookingType::class)
                    ->native(false),
                SelectFilter::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление заявки'),
                RestoreAction::make()->modalHeading('Восстановление заявки'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
