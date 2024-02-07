<?php

namespace Database\Seeders;

use App\Domain\Locations\Models\Filial;
use Illuminate\Database\Seeder;

class FilialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['пр. Ленина, 70', 1], ['ул. Сибирская, 109', 1], ['ул. С. Лазо, 4/2', 1]];

        foreach ($data as $item) {
            Filial::query()->firstOrCreate([
                'address' => $item[0],
                'city_id' => $item[1]
            ]);
        }
    }
}
