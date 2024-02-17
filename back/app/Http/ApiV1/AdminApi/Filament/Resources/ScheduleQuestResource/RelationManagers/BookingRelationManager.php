<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\RelationManagers;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingRelationManager extends RelationManager
{
    protected static string $relationship = 'booking';

    protected static ?string $recordTitleAttribute = 'phone';

    protected static ?string $label = 'Заявка на бронирование';

    protected static ?string $pluralLabel = 'Заявки на бронирование';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->rules(['size:18'])
                    ->mask('+7 (999) 999-99-99')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'size' => 'Поле ":attribute" должно содержать 18 символов.',
                    ]),
                Forms\Components\Select::make('type')
                    ->label('Тип заявки')
                    ->options(BookingType::class)
                    ->default(BookingType::QUEST->getLabel())
                    ->required()
                    ->disableOptionWhen(fn(string $value) => $value !== BookingType::QUEST->getLabel())
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                Forms\Components\Select::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::NEW->getLabel())
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('count_participants')
                    ->label('Количество участников')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'numeric' => 'Поле ":attribute" должно быть числом',
                        'min' => 'Поле ":attribute" должно быть больше 0',
                    ]),
                Forms\Components\TextInput::make('final_price')
                    ->label('Общая стоимость')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'numeric' => 'Поле ":attribute" должно быть числом',
                        'min' => 'Поле ":attribute" должно быть больше 0',
                    ]),
                Forms\Components\TextInput::make('comment')
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
            ->recordTitleAttribute('id')
            ->heading('Заявки на бронирование')
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
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn(Tables\Actions\AttachAction $action) => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('count_participants')
                            ->label('Количество участников')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'numeric' => 'Поле ":attribute" должно быть числом',
                                'min' => 'Поле ":attribute" должно быть больше 0',
                            ]),
                        Forms\Components\TextInput::make('final_price')
                            ->label('Общая стоимость')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'numeric' => 'Поле ":attribute" должно быть числом',
                                'min' => 'Поле ":attribute" должно быть больше 0',
                            ]),
                        Forms\Components\TextInput::make('comment')
                            ->label('Комментарий')
                            ->maxLength(255)
                    ])
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query
                        ->where('type', BookingType::QUEST->value))
                    ->recordSelectSearchColumns(['id'])
                    ->after(fn(RelationManager $livewire) => $livewire->ownerRecord->update(['activity_status' => false]))
                    ->attachAnother(false),
                Tables\Actions\CreateAction::make()
                    ->after(fn(RelationManager $livewire) => $livewire->ownerRecord->update(['activity_status' => false]))
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
            ]);
    }
}
