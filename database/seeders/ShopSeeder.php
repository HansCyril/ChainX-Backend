<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Frames', 'Wheels', 'Brakes', 'Drivetrain', 
            'Handlebars', 'Saddles', 'Tires', 'Accessories'
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category),
                'is_active' => true,
            ]);
        }

        $brands = ['Shimano', 'SRAM', 'Specialized', 'Trek', 'Giant', 'Canyon'];

        foreach ($brands as $brand) {
            \App\Models\Brand::create([
                'name' => $brand,
                'slug' => \Illuminate\Support\Str::slug($brand),
                'is_active' => true,
            ]);
        }
    }
}
