<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['admin', 'operator', 'filial_admin', 'actor'];

        foreach ($data as $item) {
            Role::query()->firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
