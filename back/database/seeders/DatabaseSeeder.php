<?php

namespace Database\Seeders;


use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            FilialSeeder::class,
            RoomSeeder::class,
            TypeSeeder::class,
            GenreSeeder::class,
            LevelSeeder::class,
            AgeLimitSeeder::class,
        ]);

        User::query()->firstOrCreate([
            'name' => 'bogdan',
            'surname' => 'mukhatdisov',
            'login' => 'admin2',
            'password' => Hash::make('12345678'),
            'role' => Role::ADMIN->value,
        ]);
    }
}
