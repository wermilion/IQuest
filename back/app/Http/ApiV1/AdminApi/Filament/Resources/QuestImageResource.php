<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Quests\Models\QuestImage;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestImageResource\Pages\CreateQuestImage;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestImageResource\Pages\EditQuestImage;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestImageResource\Pages\ListQuestImages;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestImageResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = QuestImage::class;

    protected static ?string $modelLabel = 'Картинка';

    protected static ?string $pluralModelLabel = 'Изображения';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = NavigationGroup::QUEST_COMPONENTS->value;

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
                    ])
                    ->native(false),
                Forms\Components\FileUpload::make('image')
                    ->directory('quest_images')
                    ->label('Изображение')
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением'
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
            ])
            ->emptyStateHeading('Изображения квестов не обнаружены');
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
            'index' => ListQuestImages::route('/'),
            'create' => CreateQuestImage::route('/create'),
            'edit' => EditQuestImage::route('/{record}/edit'),
        ];
    }
}
