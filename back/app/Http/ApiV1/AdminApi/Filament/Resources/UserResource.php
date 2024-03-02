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
use App\Http\ApiV1\AdminApi\Filament\Rules\LatinNumberRule;
use Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Пользователь';

    protected static ?string $pluralModelLabel = 'Пользователи';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->label('Город')
                    ->placeholder('Выберите город')
                    ->live()
                    ->options(City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->hidden(Auth::user()->role !== Role::ADMIN)
                    ->native(false),
                Select::make('filials')
                    ->label('Филиалы')
                    ->placeholder('Выберите филиалы')
                    ->multiple()
                    ->relationship(
                        'filials',
                        'address',
                        fn(Builder $query, Get $get): Builder => $query->where('city_id', $get('city')))
                    ->hidden(Auth::user()->role !== Role::ADMIN)
                    ->native(false),
                TextInput::make('name')
                    ->autofocus()
                    ->label('Имя')
                    ->required()
                    ->maxLength(40)
                    ->rules([new CyrillicRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('surname')
                    ->label('Фамилия')
                    ->rules([new CyrillicRule])
                    ->maxLength(40)
                    ->validationMessages([
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('login')
                    ->label('Логин')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(40)
                    ->rules([new LatinNumberRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                Select::make('role')
                    ->label('Роль')
                    ->options(Role::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->disabled(Auth::user()->role !== Role::ADMIN)
                    ->native(false),
                TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->revealable()
                    ->required()
                    ->hiddenOn('edit')
                    ->minLength(8)
                    ->maxLength(32)
                    ->rules([new LatinNumberRule()])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно содержать не менее :min символов.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('password_confirmation')
                    ->label('Подтверждение пароля')
                    ->password()
                    ->same('password')
                    ->revealable()
                    ->required()
                    ->hiddenOn('edit')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'same' => 'Поле ":attribute" должно совпадать с полем "Пароль".',
                    ]),
                TextInput::make('vk_id')
                    ->label('VK ID')
                    ->unique(ignoreRecord: true)
                    ->numeric()
                    ->rules([
                        'digits_between:1,19',
                    ])
                    ->validationMessages([
                        'unique' => 'Поле ":Attribute" должно быть уникальным.',
                        'digits_between' => 'Поле ":Attribute" должно содержать от 1 до 19 цифр.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (Auth::user()->role !== Role::ADMIN) {
                    $query->where('id', Auth::user()->id);
                }
            })
            ->emptyStateHeading('Пользователи не обнаружены')
            ->columns([
                TextColumn::make('filials.address')
                    ->label('Филиалы'),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('surname')
                    ->label('Фамилия')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('login')
                    ->label('Логин')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Роль')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('location')
                    ->form([
                        Select::make('city_id')
                            ->label('Город')
                            ->live()
                            ->placeholder('Выберите город')
                            ->options(City::all()->pluck('name', 'id'))
                            ->native(false),
                        Select::make('filial_id')
                            ->label('Филиал')
                            ->placeholder('Выберите филиал')
                            ->options(fn(Get $get): Collection => Filial::query()
                                ->where('city_id', $get('city_id'))
                                ->pluck('address', 'id'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn(Builder $query, $city_id): Builder => $query
                                    ->whereHas('filials', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->whereHas('filials', fn(Builder $query): Builder => $query->where('filial_id', $filial_id)),
                            );
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::where('id', $data['city_id'])
                                ->first()->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::where('id', $data['filial_id'])
                                ->first()->address;
                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
            ]);
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
