<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\RelationManagers;

use App\Domain\Users\Enums\Role;
use Auth;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
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
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(40)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно 1.',
                    ]),
                TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно 1.',
                    ]),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Пакеты')
            ->recordTitleAttribute('name')
            ->emptyStateHeading('Пакеты не обнаружены')
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
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->disabled(Auth::user()->role !== Role::ADMIN)
                    ->sortable(),
            ])
            ->defaultSort('sequence_number')
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make()->modalHeading('Редактирование пакета'),
                ViewAction::make()->modalHeading('Просмотр пакета'),
                DeleteAction::make(),
            ]);
    }
}
