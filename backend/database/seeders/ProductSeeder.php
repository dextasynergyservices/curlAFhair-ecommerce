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
        Product::insert([
            [
                'name' => 'Deep Conditioner',
                'price' => 12000.00,
                'category' => 'Conditioner',
                'description' => 'This is for Deeep Conditioner.',
                'quantity' => '300ml',
                'image' => 'deepconditioner.png',
                'stock' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Curl Definer',
                'price' => 11000.00,
                'category' => 'Definer',
                'description' => 'Curl Definer for definer.',
                'quantity' => '300ml',
                'image' => 'curldefiner.jpg',
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hair Butter',
                'price' => 11500.00,
                'category' => 'Butter',
                'description' => 'Hair Butter for hair growth',
                'quantity' => '300ml',
                'image' => 'hairbutter.jpg',
                'stock' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
