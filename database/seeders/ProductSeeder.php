<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sony WH-1000XM4',
                'description' => 'Industry-leading noise canceling with Dual Noise Sensor technology',
                'price' => 349.99,
                'stock_quantity' => 50,
                'image_url' => 'https://m.media-amazon.com/images/I/61uEylJzCmL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Bose QuietComfort 45',
                'description' => 'Premium noise cancelling headphones with world-class sound',
                'price' => 329.00,
                'stock_quantity' => 30,
                'image_url' => 'https://m.media-amazon.com/images/I/51QxA-98Q+L._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Apple AirPods Max',
                'description' => 'High-fidelity audio with Active Noise Cancellation',
                'price' => 549.00,
                'stock_quantity' => 25,
                'image_url' => 'https://m.media-amazon.com/images/I/81OdA-ITspL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Sennheiser HD 660 S',
                'description' => 'Open-back dynamic headphones for audiophiles',
                'price' => 499.95,
                'stock_quantity' => 15,
                'image_url' => 'https://m.media-amazon.com/images/I/61Nkcm6wDmL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Beyerdynamic DT 990 Pro',
                'description' => 'Open studio headphones for critical listening',
                'price' => 179.00,
                'stock_quantity' => 40,
                'image_url' => 'https://m.media-amazon.com/images/I/61Nkcm6wDmL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Audio-Technica ATH-M50x',
                'description' => 'Professional studio monitor headphones',
                'price' => 149.00,
                'stock_quantity' => 60,
                'image_url' => 'https://m.media-amazon.com/images/I/71YLUxNgakL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'JBL Live 660NC',
                'description' => 'Wireless over-ear headphones with ANC',
                'price' => 199.95,
                'stock_quantity' => 35,
                'image_url' => 'https://m.media-amazon.com/images/I/61tG9yKtUIL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Skullcandy Crusher Evo',
                'description' => 'Wireless headphones with sensory bass',
                'price' => 179.99,
                'stock_quantity' => 45,
                'image_url' => 'https://m.media-amazon.com/images/I/61O35s2SDML._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Beats Studio3 Wireless',
                'description' => 'Noise cancelling over-ear headphones',
                'price' => 349.95,
                'stock_quantity' => 20,
                'image_url' => 'https://m.media-amazon.com/images/I/51mgZRwCqiL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Sony WF-1000XM4',
                'description' => 'Industry-leading noise canceling earbuds',
                'price' => 278.00,
                'stock_quantity' => 55,
                'image_url' => 'https://m.media-amazon.com/images/I/61XZQXFQeVL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Jabra Elite 85h',
                'description' => 'Smart noise cancelling headphones',
                'price' => 199.99,
                'stock_quantity' => 30,
                'image_url' => 'https://m.media-amazon.com/images/I/61yGSh0cOEL._AC_SL1500_.jpg'
            ],
            [
                'name' => 'Bose QuietComfort Earbuds',
                'description' => 'True wireless earbuds with noise cancellation',
                'price' => 279.00,
                'stock_quantity' => 40,
                'image_url' => 'https://m.media-amazon.com/images/I/51UBRq2XMeL._AC_SL1500_.jpg'
            ]
            // Add more products...
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }

        // Attach relationships (after products are created)
        $sony = Product::where('name', 'Sony WH-1000XM4')->first();
        $sony->brands()->attach(1); // Sony brand
        $sony->types()->attach(1); // Over-ear
        $sony->features()->attach([2, 3]); // Noise Cancellation, Bluetooth
        $sony->colors()->attach([1, 3]); // Black, Silver

        $bose = Product::where('name', 'Bose QuietComfort 45')->first();
        $bose->brands()->attach(2); // Bose brand
        $bose->types()->attach(1); // Over-ear
        $bose->features()->attach([1, 2, 3]); // Wireless, Noise Cancellation, Bluetooth
        $bose->colors()->attach([1, 2]); // Black, White

    }
}
