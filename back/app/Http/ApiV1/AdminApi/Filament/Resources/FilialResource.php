<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\Filial;
use App\Filament\Resources\FilialResource\Pages;
use App\Filament\Resources\FilialResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FilialResource extends Resource
{
    protected static ?string $model = Filial::class;

    protected static ?string $modelLabel = 'Филиал';

    protected static ?string $pluralModelLabel = 'Филиалы';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = NavigationGroup::LOCATIONS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\TextInput::make('address')
                    ->label('Адрес')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Адрес')
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
                Tables\Filters\SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('city', 'name'),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
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
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\ListFilials::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\CreateFilial::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\EditFilial::route('/{record}/edit'),
        ];
    }
}
