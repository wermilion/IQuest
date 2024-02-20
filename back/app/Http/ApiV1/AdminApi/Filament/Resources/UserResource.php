<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\CreateUser;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\EditUser;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages\ListUsers;
use App\Http\ApiV1\AdminApi\Filament\Rules\CyrillicRule;
use App\Http\ApiV1\AdminApi\Filament\Rules\LatinRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
                    ->hiddenOn('')
                    ->native(false),
                Forms\Components\Select::make('filial_id')
                    ->label('Филиал')
                    ->options(fn(Get $get) => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->native(false),
                Forms\Components\TextInput::make('name')
                    ->autofocus()
                    ->label('Имя')
                    ->required()
                    ->maxLength(40)
                    ->rules([new CyrillicRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ]),
                Forms\Components\TextInput::make('surname')
                    ->label('Фамилия')
                    ->rules([new CyrillicRule])
                    ->maxLength(40),
                Forms\Components\TextInput::make('login')
                    ->label('Логин')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(40)
                    ->rules([new LatinRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                    ]),
                Forms\Components\Select::make('role')
                    ->label('Роль')
                    ->options(Role::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->same('password_confirmation')
                    ->revealable()
                    ->required()
                    ->hiddenOn('edit')
                    ->minLength(8)
                    ->maxLength(32)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно содержать не менее 8 символов.',
                        'max' => 'Поле ":attribute" должно содержать не более 32 символов.',
                        'same' => 'Поле ":attribute" должно совпадать с полем "Подтверждение пароля".',
                    ]),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Подтверждение пароля')
                    ->password()
                    ->revealable()
                    ->required()
                    ->hiddenOn('edit')
                    ->minLength(8)
                    ->maxLength(32)
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Forms\Components\TextInput::make('vk_id')
                    ->label('VK ID')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->validationMessages([
                        'unique' => 'Поле ":Attribute" должно быть уникальным.',
                    ]),
            ]);
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->id !== $record->id;
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
                    ->relationship('filial.city', 'name')
                    ->native(false),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ])
            ->emptyStateHeading('Пользователи не обнаружены');
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
