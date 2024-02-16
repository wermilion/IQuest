<?php

namespace Database\Seeders;

use App\Domain\Quests\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Легкий', 'Средний', 'Сложный'];

        foreach ($data as $item) {
            Level::query()->firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
