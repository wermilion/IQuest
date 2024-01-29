<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::query()->firstOrCreate([
                'name' => 'bogdan',
                'email' => 'mukhatdisov.b@yandex.ru',
                'password' => Hash::make('12345678')
            ]);
        } catch (QueryException) {
            echo "Такой пользователь уже существует\n";
        }
    }
}
