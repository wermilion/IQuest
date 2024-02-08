<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Users\Models\User;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Http\ApiV1\FrontApi\Enums\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Пользователь';

    protected static ?string $pluralModelLabel = 'Пользователи';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id'),
                Forms\Components\Select::make('city')
                    ->label('Город')
                    ->live()
                    ->options(fn() => City::all()->pluck('name', 'id'))
                    ->hiddenOn(''),
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->relationship('filial', 'address')
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id')),
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('surname')
                    ->label('Фамилия')
                    ->maxLength(255),
                Forms\Components\TextInput::make('login')
                    ->label('Логин')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'email' => 'Поле ":attribute" должно быть в формате почты.'
                    ]),
                Forms\Components\Select::make('role')
                    ->label('Роль')
                    ->options(Role::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('vk_id')
                    ->label('VK ID')
                    ->unique()
                    ->maxLength(255)
                    ->validationMessages([
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('surname')
                    ->label('Фамилия')
                    ->searchable(),
                Tables\Columns\TextColumn::make('login')
                    ->label('Логин')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Роль')
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('filial.city', 'name'),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
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
            'index' => \App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\ListUsers::route('/'),
            'create' => \App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\CreateUser::route('/create'),
            'edit' => \App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
