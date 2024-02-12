<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Holidays\Models\HolidayPackage;
use App\Filament\Resources\HolidayPackageResource\Pages;
use App\Filament\Resources\HolidayPackageResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\CreateHolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\EditHolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\ListHolidayPackages;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HolidayPackageResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = HolidayPackage::class;

    protected static ?string $modelLabel = 'Пакет праздника';

    protected static ?string $pluralModelLabel = 'Пакеты праздников';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::HOLIDAYS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('holiday_id')
                    ->relationship('holiday', 'id')
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('package_id')
                    ->relationship('package', 'name')
                    ->required()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('holiday.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('package.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => ListHolidayPackages::route('/'),
            'create' => CreateHolidayPackage::route('/create'),
            'edit' => EditHolidayPackage::route('/{record}/edit'),
        ];
    }
}
