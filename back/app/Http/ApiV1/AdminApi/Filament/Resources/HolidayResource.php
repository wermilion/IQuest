<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Holidays\Enums\HolidayType;
use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages\EditHoliday;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages\ListHolidays;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\RelationManagers\PackagesRelationManager;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $modelLabel = 'Праздник';

    protected static ?string $pluralModelLabel = 'Праздники';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('Тип праздника')
                    ->options(HolidayType::class)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.'
                    ])
                    ->native(false)
                    ->disabled(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Праздники не обнаружены')
            ->columns([
                TextColumn::make('type')
                    ->label('Тип праздника'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
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
            'edit' => EditHoliday::route('/{record}/edit'),
        ];
    }
}
