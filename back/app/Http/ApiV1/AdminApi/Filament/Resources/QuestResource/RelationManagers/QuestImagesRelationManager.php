<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class QuestImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $label = 'изображение';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->directory('quest_images')
                    ->label('Изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Изображения')
            ->recordTitleAttribute('image')
            ->emptyStateHeading('Изображений не обнаружено')
            ->emptyStateDescription('Добавить изображение')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение')
                    ->width(200)
                    ->height(200),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Добавить')
                    ->modalHeading('Добавление изображения')
                    ->modalSubmitActionLabel('Добавить')
                    ->createAnother(false),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление изображения'),
            ]);
    }
}
