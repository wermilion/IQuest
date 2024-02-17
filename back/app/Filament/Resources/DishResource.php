<?php

namespace App\Filament\Resources;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\DishResource\Pages;
use App\Filament\Resources\DishResource\RelationManagers;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Metric;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;


class DishResource extends Resource
{
    protected static ?string $model = Dish::class;
    protected static ?string $navigationGroup = NavigationGroupEnum::DISHES->value;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'Блюдо';
    protected static ?string $pluralLabel = 'Блюда';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    TextInput::make('title')
                        ->minLength(1)
                        ->maxLength(100)
                        ->string()
                        ->required()
                        ->autofocus()
                        ->label('Наименование'),

                    RichEditor::make('composition')
                        ->string()
                        ->minLength(1)
                        ->maxLength(150)
                        ->label('Состав')
                        ->toolbarButtons([
                            //
                        ]),

                    TextInput::make('price')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->integer()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->required()
                        ->label('Цена'),

                    Select::make('metric_id')
                        ->options(Metric::all()->pluck('title', 'id'))
                        ->reactive()
                        ->default(3)
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (is_null($state)) {
                                $set('metric_value', null);
                            }
                        })
                        ->label('Ед. измерения'),

                    TextInput::make('metric_value')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->integer()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->label('Вес/объём'),

                    Select::make('category_id')
                        ->options(function (callable $get) {
                            return Category::all()->pluck('title', 'id');
                        })
                        ->reactive()
                        ->label('Категория')
                        ->required(),

                    Select::make('subcategory_id')
                        ->options(function (callable $get) {
                            $categoryId = $get('category_id');
                            return empty($get('category_id')) ? [] : Category::find($categoryId)->subcategories->pluck('title', 'id');
                        })
                        ->required()
                        ->label('Подкатегория'),

                    TextInput::make('calorie')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->decimalPlaces(2)
                            ->decimalSeparator('.')
                            ->mapToDecimalSeparator([','])
                            ->normalizeZeros()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->label('Калорийность'),

                    TextInput::make('proteins')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->decimalPlaces(2)
                            ->decimalSeparator('.')
                            ->mapToDecimalSeparator([','])
                            ->normalizeZeros()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->label('Белки'),

                    TextInput::make('fats')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->decimalPlaces(2)
                            ->decimalSeparator('.')
                            ->mapToDecimalSeparator([','])
                            ->normalizeZeros()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->label('Жиры'),

                    TextInput::make('carbohydrates')
                        ->mask(fn(TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->decimalPlaces(2)
                            ->decimalSeparator('.')
                            ->mapToDecimalSeparator([','])
                            ->normalizeZeros()
                            ->positive()
                        )
                        ->maxLength(10)
                        ->label('Углеводы'),

                    Checkbox::make('is_available')
                        ->default(true)
                        ->label('Доступно для заказа'),

                    Checkbox::make('sugar')
                        ->default(true)
                        ->label('С сахаром'),

                    Checkbox::make('lactose')
                        ->default(true)
                        ->label('С лактозой'),

                    Checkbox::make('gluten')
                        ->default(true)
                        ->label('С глютеном'),

                    SpatieMediaLibraryFileUpload::make('preview')
                        ->collection('dishes')
                        ->maxSize(1024)
                        ->acceptedFileTypes([
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/svg',
                        ])
                        ->maxFiles(1)
                        ->required()
                        ->label('Изображение'),
                ])->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                SpatieMediaLibraryImageColumn::make('preview')
                    ->collection('dishes')
                    ->label('Изображение'),
                TextColumn::make('title')
                    ->label('Блюдо')
                    ->searchable(),
                TextColumn::make('subcategory.title')
                    ->label('Подкатегория'),
                TextColumn::make('subcategory.category.title')
                    ->label('Категория'),
                ToggleColumn::make('is_available')
                    ->label('Доступно'),
                TextColumn::make('created_at')
                    ->visible(false)
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\Fieldset::make()->schema([
                            Forms\Components\DatePicker::make('created_from')
                                ->label('')
                                ->placeholder('С:'),
                            Forms\Components\DatePicker::make('created_until')
                                ->label('')
                                ->placeholder('До:'),
                        ])->columns(1)->label('Дата создания'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                SelectFilter::make('subcategory')->form(
                    [
                        Forms\Components\Fieldset::make()->schema([
                            Select::make('category')
                                ->options(function () {
                                    return Category::all()->pluck('title', 'id');
                                })
                                ->afterStateUpdated(fn(callable $set) => $set('subcategory', null))
                                ->label('Категория'),
                            Select::make('subcategory')
                                ->options(function (callable $get) {
                                    if (empty($category = $get('category'))) {
                                        return [];
                                    }
                                    $selectedCategory = Category::query()->find($category);
                                    return $selectedCategory->subcategories->pluck('title', 'id');
                                })
                                ->reactive()
                                ->label('Подкатегория')
                        ])->columns(1)->label('Категории'),
                    ]
                )
                    ->query(function (Builder $query, $data) {
                        return $query
                            ->when(
                                $data['category'],
                                function (Builder $query, $category) {
                                    $category = Category::query()->firstWhere('id', $category);
                                    $subcategoriesId = $category->subcategories->pluck('id');
                                    return $query->whereIn('subcategory_id', $subcategoriesId);
                                }
                            )
                            ->when(
                                $data['subcategory'],
                                fn(Builder $query, $subcategory) => $query->where('subcategory_id', $subcategory)
                            );

                    }),

                Filter::make('is_available')
                    ->query(fn(Builder $query) => $query->where('is_available', false))
                    ->toggle()
                    ->label('В стоп листе'),
                Filter::make('sugar')
                    ->query(fn(Builder $query) => $query->where('sugar', false))
                    ->toggle()
                    ->label('Без сахара'),
                Filter::make('lactose')
                    ->query(fn(Builder $query) => $query->where('lactose', false))
                    ->toggle()
                    ->label('Без лактозы'),
                Filter::make('gluten')
                    ->query(fn(Builder $query) => $query->where('gluten', false))
                    ->toggle()
                    ->label('Без глютена')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDishes::route('/'),
            'create' => Pages\CreateDish::route('/create'),
            'view' => Pages\ViewDish::route('/{record}'),
            'edit' => Pages\EditDish::route('/{record}/edit'),
        ];
    }
}

