<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestImageResource\Pages;
use App\Filament\Resources\QuestImageResource\RelationManagers;
use App\Models\QuestImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestImageResource extends Resource
{
    protected static ?string $model = QuestImage::class;

    protected static ?string $modelLabel = 'Картинка';

    protected static ?string $pluralModelLabel = 'Изображения';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Компоненты квестов';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('quest_id')
                    ->label('Квест')
                    ->relationship('quest', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\FileUpload::make('image')
                    ->directory('quest_images')
                    ->label('Изображение')
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quest.name')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestImages::route('/'),
            'create' => Pages\CreateQuestImage::route('/create'),
            'edit' => Pages\EditQuestImage::route('/{record}/edit'),
        ];
    }
}
