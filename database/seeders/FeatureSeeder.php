<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'Wireless'],
            ['name' => 'Noise Cancellation'],
            ['name' => 'Bluetooth'],
            ['name' => 'Microphone'],
            ['name' => 'Water Resistant'],
            ['name' => 'Foldable'],
            ['name' => 'Bass Boost'],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
