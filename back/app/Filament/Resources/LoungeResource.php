<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoungeResource\Pages;
use App\Filament\Resources\LoungeResource\RelationManagers;
use App\Filament\Resources\LoungeResource\RelationManagers\ImagesRelationManager;
use App\Models\Lounge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoungeResource extends Resource
{
    protected static ?string $model = Lounge::class;
    protected static ?string $modelLabel = 'Лаундж';

    protected static ?string $pluralModelLabel = 'Лаунджи';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Лаундж-зоны';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->required()
                    ->relationship('filial', 'address'),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filial.address')
                    ->label('Адрес')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
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
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLounges::route('/'),
            'create' => Pages\CreateLounge::route('/create'),
            'edit' => Pages\EditLounge::route('/{record}/edit'),
        ];
    }
}
