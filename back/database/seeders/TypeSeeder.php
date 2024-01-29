<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Морфеус-квест', 'Реалити-квест', 'Перформанс-квест'];

        foreach ($data as $item) {
            Type::query()->firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
