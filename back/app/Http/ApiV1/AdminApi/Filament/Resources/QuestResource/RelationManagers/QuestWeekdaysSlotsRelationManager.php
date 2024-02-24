<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestWeekdaysSlotsRelationManager extends RelationManager
{
    protected static string $relationship = 'questWeekdaysSlots';

    protected static ?string $label = 'слот';

    protected static ?string $pluralLabel = 'Тайм-слоты';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('time')
                    ->label('Время')
                    ->mask('99:99')
                    ->placeholder('00:00')
                    ->required()
                    ->rules([
                        'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'regex' => 'Поле ":attribute" должно быть в формате "00:00".',
                    ]),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Расписание по будням')
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
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make()->modalHeading('Изменить слот'),
                DeleteAction::make()->modalHeading('Удалить слот'),
            ]);
    }
}
