<?php

namespace App\Filament\Resources;

use App\Enums\NavigationGroupEnum;
use App\Enums\TargetEnums;
use App\Filament\Resources\MainBlockResource\Pages;
use App\Filament\Resources\MainBlockResource\RelationManagers;
use App\Models\Block;
use App\Models\MainBlock;
use App\Models\Target;
use App\Traits\BlockTrait;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class MainBlockResource extends Resource
{
    use BlockTrait;

    protected static ?string $model = Block::class;
    protected static ?string $navigationGroup = NavigationGroupEnum::BLOCKS->value;

    protected static ?string $label = 'Главный';
    protected static ?string $pluralLabel = 'Главный';
    protected static ?string $slug = 'main-block';
    protected static ?string $navigationIcon = 'heroicon-o-photograph';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('images')
                    ->collection('mainBlock')
                    ->maxSize(1024)
                    ->acceptedFileTypes([
                        'image/jpg',
                        'image/jpeg',
                        'image/png',
                        'image/svg',
                    ])
                    ->multiple()
                    ->minFiles(1)
                    ->maxFiles(5)
                    ->enableReordering()
                    ->helperText('Максимум 5 изображений.')
                    ->label('Изображения')
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    SpatieMediaLibraryImageColumn::make('images')
                        ->collection('mainBlock')
                        ->label('Изображение'),
                    TextColumn::make('target.title')
                        ->label('Блок')]),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListMainBlocks::route('/'),
        ];
    }
}
