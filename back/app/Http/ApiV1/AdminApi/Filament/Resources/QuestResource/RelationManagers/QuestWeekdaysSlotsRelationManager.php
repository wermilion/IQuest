<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestWeekdaysSlotsRelationManager extends RelationManager
{
    protected static string $relationship = 'questWeekdaysSlots';

    protected static ?string $label = 'слот';

    protected static ?string $pluralLabel = 'Тайм-слоты';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('time')
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
                Forms\Components\TextInput::make('price')
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
                Tables\Columns\TextColumn::make('time')
                    ->label('Время')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->sortable(),
            ])
            ->defaultSort('time')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalHeading('Изменить слот'),
                Tables\Actions\DeleteAction::make()->modalHeading('Удалить слот'),
            ]);
    }
}
