<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'packages';

    protected static ?string $label = 'Пакет';

    protected static ?string $pluralModelLabel = 'Пакеты';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(40)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно 1.',
                    ]),
                Forms\Components\TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                Forms\Components\RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Пакеты')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->numeric(),
                Tables\Columns\TextColumn::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->numeric(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->sortable(),
            ])
            ->defaultSort('sequence_number')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('Пакеты не обнаружены');
    }
}
