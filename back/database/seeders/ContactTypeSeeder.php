<?php

namespace Database\Seeders;

use App\Domain\Contacts\Models\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Номер телефона',
            'Почта',
            'YouTube',
            'VK',
            'Telegram',
            'Instagram',
        ];

        foreach ($data as $value) {
            ContactType::firstOrCreate([
                'name' => $value,
            ]);
        }
    }
}
