<?php

namespace Database\Seeders;

use App\Models\AgeLimit;
use App\Models\Room;
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
            RoleSeeder::class,
        ]);

        User::query()->createOrFirst([
            'name' => 'bogdan',
            'surname' => 'mukhatdisov',
            'login' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
        ]);
    }
}
