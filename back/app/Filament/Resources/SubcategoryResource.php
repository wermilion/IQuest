<?php

namespace App\Filament\Resources;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\SubcategoryResource\Pages;
use App\Filament\Resources\SubcategoryResource\RelationManagers;
use App\Models\Subcategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubcategoryResource extends Resource
{
    protected static ?string $model = Subcategory::class;
    protected static ?string $navigationGroup = NavigationGroupEnum::DISHES->value;

    protected static ?string $label = 'Подкатегория';
    protected static ?string $pluralLabel = 'Подкатегории';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Select::make('category_id')
                        ->relationship('category', 'title')
                        ->placeholder('Выбрать')
                        ->required()
                        ->autofocus()
                        ->label('Родительская категория'),

                    TextInput::make('title')
                        ->minLength(1)
                        ->maxLength(20)
                        ->string()
                        ->required()
                        ->label('Подкатегория'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Подкатегория'),
                TextColumn::make('category.title')
                    ->label('Категория'),
            ])
            ->filters([
                SelectFilter::make('parentCategory')
                    ->relationship('category', 'title')
                    ->label('Категория')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListSubcategories::route('/'),
            'edit' => Pages\EditSubcategory::route('/{record}/edit'),
        ];
    }
}
