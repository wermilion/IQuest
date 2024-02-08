<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Filament\Resources\HolidayPackageResource\Pages;
use App\Filament\Resources\HolidayPackageResource\RelationManagers;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use App\Models\HolidayPackage;
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
                    ->required(),
                Forms\Components\Select::make('package_id')
                    ->relationship('package', 'name')
                    ->required(),
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
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\ListHolidayPackages::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\CreateHolidayPackage::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\HolidayPackageResource\Pages\EditHolidayPackage::route('/{record}/edit'),
        ];
    }
}
