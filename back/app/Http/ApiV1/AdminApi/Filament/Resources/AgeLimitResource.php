<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Quests\Models\AgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\CreateAgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\EditAgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\ListAgeLimits;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AgeLimitResource extends Resource
{
    protected static ?string $model = AgeLimit::class;

    protected static ?string $modelLabel = 'Возрастное ограничение';

    protected static ?string $pluralModelLabel = 'Возрастные ограничения';

    protected static ?string $navigationLabel = 'Возрастные ограничения';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Компоненты квестов';

    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('limit')
                    ->label('Возрастное ограничение')
                    ->required()
                    ->unique()
                    ->maxLength(255)
                    ->validationMessages([
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('limit')
                    ->label('Возрастное ограничение')
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
            ])
            ->emptyStateHeading('Возрастные ограничения не обнаружены');
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
            'index' => ListAgeLimits::route('/'),
            'create' => CreateAgeLimit::route('/create'),
            'edit' => EditAgeLimit::route('/{record}/edit'),
        ];
    }
}
