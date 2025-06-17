<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Over-ear'],
            ['name' => 'On-ear'],
            ['name' => 'In-ear'],
            ['name' => 'Earbuds'],
            ['name' => 'True Wireless'],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
