<?php

namespace Database\Seeders;

use App\Models\Metric;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Metric::query()->firstOrCreate(
            [
                'title' => 'мл',
            ]);
        Metric::query()->firstOrCreate(
            [
                'title' => 'л',
            ]);
        Metric::query()->firstOrCreate(
            [
                'title' => 'г',
            ]);
        Metric::query()->firstOrCreate(
            [
                'title' => 'кг',
            ]);
    }
}
