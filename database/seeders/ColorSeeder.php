<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Silver', 'hex_code' => '#C0C0C0'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Gold', 'hex_code' => '#FFD700'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
