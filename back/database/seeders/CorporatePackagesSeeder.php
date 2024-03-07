<?php

namespace Database\Seeders;

use App\Domain\Holidays\Enums\HolidayType;
use App\Domain\Holidays\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporatePackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $corporateHoliday = Holiday::where('type', HolidayType::CORPORATE->value)->first();
        $packages = [
            [
                'name' => 'Квест под ключ',
                'description' => 'Описание квеста под ключ',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 1,
            ],
            [
                'name' => 'Живой квест "Чужой"',
                'description' => 'Описание живого квеста "Чужой"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 2,
            ],
            [
                'name' => 'Живой квест "Чикаго"',
                'description' => 'Описание живого квеста "Чикаго"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 3,
            ],
            [
                'name' => 'Живой квест "Тортуга"',
                'description' => 'Описание живого квеста "Тортуга"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 4,
            ],
            [
                'name' => 'Живой квест "Ведьмин Дол"',
                'description' => 'Описание живого квеста "Ведьмин Дол"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 5,
            ],
            [
                'name' => 'Живой квест "Спасти королеву"',
                'description' => 'Описание живого квеста "Спасти королеву"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 6,
            ],
            [
                'name' => 'Живой квест "Одержимые"',
                'description' => 'Описание живого квеста "Одержимые"',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 7,
            ],
        ];

        foreach ($packages as $package) {
            $corporateHoliday->packages()->firstOrCreate($package);
        }
    }
}
