<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Holidays\Models\Holiday;
use App\Filament\Resources\HolidayResource\Pages;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages\CreateHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages\EditHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages\ListHolidays;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\RelationManagers\PackagesRelationManager;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use App\Http\ApiV1\FrontApi\Enums\HolidayType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $modelLabel = 'Праздник';

    protected static ?string $pluralModelLabel = 'Праздники';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::HOLIDAYS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Тип праздника')
                    ->options(HolidayType::class)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.'
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип праздника')
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
            PackagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHolidays::route('/'),
            'create' => CreateHoliday::route('/create'),
            'edit' => EditHoliday::route('/{record}/edit'),
        ];
    }
}
