<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoungeResource\Pages;
use App\Filament\Resources\LoungeResource\RelationManagers;
use App\Filament\Resources\LoungeResource\RelationManagers\ImagesRelationManager;
use App\Models\City;
use App\Models\Filial;
use App\Models\Lounge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->relationship('filial', 'address')
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->unique()
                    ->maxLength(255)
                    ->validationMessages([
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\Textarea::make('description')
                    ->label('Описание')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filial.city.name')
                    ->label('Город')
                    ->sortable(),
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
