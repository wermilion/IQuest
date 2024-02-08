<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Holidays\Models\Package;
use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $modelLabel = 'Пакет';

    protected static ?string $pluralModelLabel = 'Пакеты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::HOLIDAYS->value;

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('holidayPackages.holiday.type')
                    ->label('Тип праздника')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages\ListPackages::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages\CreatePackage::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\PackageResource\Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
