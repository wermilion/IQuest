<?php

namespace Database\Seeders;

use App\Domain\Locations\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['Первая комната первого филиала', 1], ['Вторая комната первого филиала', 1], ['Комната второго филиала', 2]];

        foreach ($data as $item) {
            Room::query()->firstOrCreate([
                'name' => $item[0],
                'filial_id' => $item[1]
            ]);
        }
    }
}
