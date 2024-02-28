<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\RelationManagers;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
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

    protected static ?string $label = 'заявку';

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
                    ->default(BookingType::LOUNGE->getLabel())
                    ->required()
                    ->disableOptionWhen(fn(string $value) => $value !== BookingType::LOUNGE->getLabel())
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
            ->recordTitleAttribute('id')
            ->emptyStateHeading('Нет заявки')
            ->emptyStateDescription('Создать или прикрепить заявку')
            ->heading('Заявка')
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->label('Телефон'),
                TextColumn::make('comment')
                    ->label('Комментарий'),
                SelectColumn::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class),
            ])
            ->paginated(false)
            ->headerActions([
                AttachAction::make()
                    ->modalHeading('Прикрепить заявку')
                    ->form(fn(AttachAction $action) => [
                        $action->getRecordSelect()->placeholder('Введите ID заявки'),
                        TextInput::make('comment')
                            ->label('Комментарий')
                            ->maxLength(255)
                    ])
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query
                        ->where('type', BookingType::LOUNGE->value)
                        ->whereDoesntHave('scheduleLounges'))
                    ->attachAnother(false)
                    ->recordSelectSearchColumns(['id']),
                CreateAction::make()
                    ->modalHeading('Создание заявки')
                    ->createAnother(false),
            ])
            ->actions([
                EditAction::make()->modalHeading('Редактирование заявки'),
                DeleteAction::make()->modalHeading('Удалить заявку'),
            ]);
    }
}
