<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Триллер', 'Детектив', 'Комедия', 'Мистика', 'Детский'];

        foreach ($data as $item) {
            Genre::query()->firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
