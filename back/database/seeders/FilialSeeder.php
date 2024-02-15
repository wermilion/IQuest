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
        $data = [['пр. Ленина, 70', 'здесь метка', 1], ['ул. Сибирская, 109', 'здесь метка', 1], ['ул. С. Лазо, 4/2', 'здесь метка', 1]];

        foreach ($data as $item) {
            Filial::query()->firstOrCreate([
                'address' => $item[0],
                'yandex_mark' => $item[1],
                'city_id' => $item[2]
            ]);
        }
    }
}
