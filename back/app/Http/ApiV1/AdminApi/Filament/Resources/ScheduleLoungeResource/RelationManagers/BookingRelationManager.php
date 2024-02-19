<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\RelationManagers;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingRelationManager extends RelationManager
{
    protected static string $relationship = 'booking';

    protected static ?string $label = 'заявку';

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
                    ->default(BookingType::LOUNGE->getLabel())
                    ->required()
                    ->disableOptionWhen(fn(string $value) => $value !== BookingType::LOUNGE->getLabel())
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
            ->emptyStateHeading('Нет заявки')
            ->emptyStateDescription('Создать или прикрепить заявку')
            ->heading('Заявка')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон'),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class),
            ])
            ->filters([
                //
            ])
            ->paginated(false)
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->modalHeading('Прикрепить заявку')
                    ->form(fn(Tables\Actions\AttachAction $action) => [
                        $action->getRecordSelect()->placeholder('Введите ID заявки'),
                        Forms\Components\TextInput::make('comment')
                            ->label('Комментарий')
                            ->maxLength(255)
                    ])
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query
                        ->where('type', BookingType::LOUNGE->value)
                        ->withoutTrashed())
                    ->attachAnother(false)
                    ->recordSelectSearchColumns(['id']),
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->modalHeading('Удалить заявку'),
            ]);
    }
}
