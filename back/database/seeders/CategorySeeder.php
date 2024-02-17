<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->firstOrCreate(
            [
                'title' => 'Завтраки',
            ],
            [
                'priority' => 1,
                'weekday_available_start' => '8:00:00',
                'weekday_available_end' => '12:00:00',
                'weekend_available_start' => '8:00:00',
                'weekend_available_end' => '16:00:00',
            ]
        );
        Category::query()->firstOrCreate(
            [
                'title' => 'Бизнес-ланч',
            ],
            [
                'priority' => 2,
                'weekday_available_start' => '12:00:00',
                'weekday_available_end' => '16:00:00',
            ]
        );
        Category::query()->firstOrCreate(
            [
                'title' => 'Основное меню',
            ],
            [
                'priority' => 3,
                'weekday_available_start' => '00:00:00',
                'weekday_available_end' => '23:59:59',
                'weekend_available_start' => '00:00:00',
                'weekend_available_end' => '23:59:59',
            ]
        );
        Category::query()->firstOrCreate(
            [
                'title' => 'Лавка',
            ],
            [
                'priority' => 4,
                'weekday_available_start' => '00:00:00',
                'weekday_available_end' => '23:59:59',
                'weekend_available_start' => '00:00:00',
                'weekend_available_end' => '23:59:59',
            ]
        );

    }
}
