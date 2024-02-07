<?php

namespace Database\Seeders;

use App\Domain\Locations\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Томск', 'Омск', 'Краснодар'];

        foreach ($data as $item) {
            City::query()->firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
