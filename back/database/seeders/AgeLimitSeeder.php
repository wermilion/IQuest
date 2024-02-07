<?php

namespace Database\Seeders;

use App\Domain\Quests\Models\AgeLimit;
use Illuminate\Database\Seeder;

class AgeLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['0+', '12+', '16+', '18+'];

        foreach ($data as $item) {
            AgeLimit::query()->firstOrCreate([
                'limit' => $item
            ]);
        }
    }
}
