<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\RelationManagers;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingRelationManager extends RelationManager
{
    protected static string $relationship = 'booking';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = 'заявку';

    protected static ?string $pluralLabel = 'Заявки на бронирование';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
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
                    ->rules(['size:18'])
                    ->mask('+7 (999) 999-99-99')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'size' => 'Поле ":attribute" должно содержать 18 символов.',
                    ]),
                Select::make('type')
                    ->label('Тип заявки')
                    ->options(BookingType::class)
                    ->default(BookingType::QUEST->getLabel())
                    ->required()
                    ->disableOptionWhen(fn(string $value) => $value !== BookingType::QUEST->getLabel())
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                Select::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::NEW->getLabel())
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                TextInput::make('count_participants')
                    ->label('Количество участников')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'numeric' => 'Поле ":attribute" должно быть числом',
                        'min' => 'Поле ":attribute" должно быть больше 0',
                    ]),
                TextInput::make('final_price')
                    ->label('Общая стоимость')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'numeric' => 'Поле ":attribute" должно быть числом',
                        'min' => 'Поле ":attribute" должно быть больше 0',
                    ]),
                TextInput::make('comment')
                    ->label('Комментарий')
                    ->maxLength(255)
            ]);
    }

    protected function canCreate(): bool
    {
        return !($this->getAllTableRecordsCount());
    }

    protected function canAttach(): bool
    {
        return !($this->getAllTableRecordsCount());
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Заявка')
            ->emptyStateHeading('Нет заявки')
            ->emptyStateDescription('Создать или прикрепить заявку')
            ->paginated(false)
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->label('Телефон'),
                SelectColumn::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class),
                TextColumn::make('count_participants')
                    ->label('Кол-во человек'),
                TextColumn::make('final_price')
                    ->label('Общая стоимость'),
                TextColumn::make('comment')
                    ->label('Комментарий'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->modalHeading('Прикрепить заявку')
                    ->form(fn(AttachAction $action) => [
                        $action->getRecordSelect()->placeholder('Введите ID заявки'),
                        TextInput::make('count_participants')
                            ->label('Количество участников')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'numeric' => 'Поле ":attribute" должно быть числом',
                                'min' => 'Поле ":attribute" должно быть больше 0',
                            ]),
                        TextInput::make('final_price')
                            ->label('Общая стоимость')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'numeric' => 'Поле ":attribute" должно быть числом',
                                'min' => 'Поле ":attribute" должно быть больше 0',
                            ]),
                        TextInput::make('comment')
                            ->label('Комментарий')
                            ->maxLength(255)
                    ])
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query
                        ->where('type', BookingType::QUEST->value)
                        ->whereDoesntHave('timeslots'))
                    ->recordSelectSearchColumns(['id'])
                    ->after(function (RelationManager $livewire, Booking $booking) {
                        $livewire->ownerRecord->update(['is_active' => false]);
                        resolve(SendMessageBookingAction::class)->execute($booking);
                    })
                    ->attachAnother(false),
                CreateAction::make()
                    ->modalHeading('Создание заявки')
                    ->after(function (RelationManager $livewire, Booking $booking) {
                        $livewire->ownerRecord->update(['is_active' => false]);
                        resolve(SendMessageBookingAction::class)->execute($booking);
                    })
                    ->createAnother(false),
            ])
            ->actions([
                EditAction::make()->modalHeading('Редактирование заявки'),
                DeleteAction::make()->modalHeading('Удалить заявку'),
            ]);
    }
}
