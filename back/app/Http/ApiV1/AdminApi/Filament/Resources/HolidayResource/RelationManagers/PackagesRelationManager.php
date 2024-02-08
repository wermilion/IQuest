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
                    ->maxLength(255)
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
                Forms\Components\TextInput::make('min_people')
                    ->label('Мин. кол-во людей')
                    ->live()
                    ->numeric()
                    ->required()
                    ->minValue('1')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно 1.',
                    ]),
                Forms\Components\TextInput::make('max_people')
                    ->label('Макс. кол-во людей')
                    ->numeric()
                    ->required()
                    ->minValue(fn(Forms\Get $get) => $get('min_people'))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно полю "Мин. кол-во людей".',
                    ]),
                Forms\Components\RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_people')
                    ->label('Мин. кол-во людей')
                    ->numeric(),
                Tables\Columns\TextColumn::make('max_people')
                    ->label('Макс. кол-во людей')
                    ->numeric(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->sortable(),
            ])
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
