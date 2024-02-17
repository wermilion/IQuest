<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::query()->firstOrCreate(
            [
                'phone' => '8(3822)50-99-90',
            ],
            [
                'email' => 'gosti.cafe@mail.ru',
                'vk' => 'https://vk.com/cafegostitomsk',
                'whatsapp' => 'https://wa.me/79138209990',
                'gis' => 'https://go.2gis.com/svx9u',
                'address' => 'Томск, просп. Фрунзе, 90',
            ]
        );
    }
}
