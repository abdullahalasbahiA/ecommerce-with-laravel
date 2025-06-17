<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Sony', 'logo_url' => 'sony-logo.png'],
            ['name' => 'Bose', 'logo_url' => 'bose-logo.png'],
            ['name' => 'Sennheiser', 'logo_url' => 'sennheiser-logo.png'],
            ['name' => 'Audio-Technica', 'logo_url' => 'audio-technica-logo.png'],
            ['name' => 'JBL', 'logo_url' => 'jbl-logo.png'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
