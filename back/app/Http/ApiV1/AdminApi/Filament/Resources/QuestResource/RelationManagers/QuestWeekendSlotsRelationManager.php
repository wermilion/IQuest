<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers;

use App\Http\ApiV1\AdminApi\Filament\Rules\TimeRule;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestWeekendSlotsRelationManager extends RelationManager
{
    protected static string $relationship = 'questWeekendSlots';

    protected static ?string $label = 'слот';

    protected static ?string $pluralLabel = 'Тайм-слоты';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('time')
                    ->label('Время')
                    ->mask('99:99')
                    ->placeholder('00:00')
                    ->required()
                    ->rules([new TimeRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->rules([
                        'regex:/^\d{1,6}(\.\d{1,2})?$/'
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше нуля.',
                        'regex' => 'Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Расписание по выходным')
            ->recordTitleAttribute('time')
            ->emptyStateHeading('Нет слотов')
            ->emptyStateDescription('Создать слот')
            ->columns([
                TextColumn::make('time')
                    ->label('Время')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Цена')
                    ->sortable(),
            ])
            ->defaultSort('time')
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Создание слота')
                    ->createAnother(false),
            ])
            ->actions([
                EditAction::make()->modalHeading('Изменение слота'),
                DeleteAction::make()->modalHeading('Удаление слота'),
            ]);
    }
}
