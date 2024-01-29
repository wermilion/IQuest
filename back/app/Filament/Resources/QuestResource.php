<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestResource\Pages;
use App\Filament\Resources\QuestResource\RelationManagers;
use App\Models\Quest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;
    protected static ?string $modelLabel = 'Квест';
    protected static ?string $pluralModelLabel = 'Квесты';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->columnSpanFull()
                    ->relationship('filial', 'address')
                    ->required(),
                Forms\Components\Select::make('type_id')
                    ->label('Тип')
                    ->relationship('type', 'name')
                    ->required(),
                Forms\Components\Select::make('genre_id')
                    ->label('Жанр')
                    ->relationship('genre', 'name')
                    ->required(),
                Forms\Components\Select::make('age_limit_id')
                    ->label('Ограничение')
                    ->relationship('age_limit', 'limit')
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->label('Уровень сложность')
                    ->relationship('level', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_slug')
                    ->label('Сокращ. название')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('desc')
                    ->label('Описание')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('min_price')
                    ->label('Мин. цена')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('late_price')
                    ->label('Вечерная цена')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('duration')
                    ->label('Продолжительность (в мин)')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('add_time')
                    ->columnSpanFull()
                    ->label('Можно ли добавить время')
                    ->required(),
                Forms\Components\FileUpload::make('cover')
                    ->disk('public')
                    ->directory('covers')
                    ->storeFileNamesIn('image_file_names')
                    ->image()
                    ->label('Обложка')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filial.address')
                    ->label('Адрес')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_slug')
                    ->label('Сокращ. название')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Обложка')
                    ->width(200)
                    ->height(200)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type.name')
                    ->label('Тип')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('genre.name')
                    ->label('Жанр')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('age_limit.id')
                    ->label('Возрастное ограничение')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Уровень сложности')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('min_price')
                    ->label('Минимальная цена')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('late_price')
                    ->label('Вечерняя цена')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Продолжительность')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('add_time')
                    ->label('Можно ли добавить время')
                    ->boolean()
                    ->hidden(),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Дата удаления')
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
            'index' => Pages\ListQuests::route('/'),
            'create' => Pages\CreateQuest::route('/create'),
            'edit' => Pages\EditQuest::route('/{record}/edit'),
        ];
    }
}
