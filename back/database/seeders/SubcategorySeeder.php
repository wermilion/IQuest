<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Завтраки 1**/
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Каши',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Драник',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Сырники',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Блюда из яиц',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Блины',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Тосты и сендвичи',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Сборные завтраки',
                'category_id' => 1,
            ],
            [
                'priority' => 1,
            ]
        );

        /**Лавка 2**/
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Приготовленное',
                'category_id' => 4,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Из заморозки',
                'category_id' => 4,
            ],
            [
                'priority' => 1,
            ]
        );

        /**Основное меню**/
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Салаты',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Закуски',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Вторые блюда',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Супы',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Гарниры',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Детское меню',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Добавки',
                'category_id' => 3,
            ],
            [
                'priority' => 1,
            ]
        );

        /**Бизнес-ланч**/
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Салаты',
                'category_id' => 2,
            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Супы',
                'category_id' => 2,

            ],
            [
                'priority' => 1,
            ]
        );
        Subcategory::query()->firstOrCreate(
            [
                'title' => 'Горячее',
                'category_id' => 2,

            ],
            [
                'priority' => 1,
            ]
        );
    }
}
