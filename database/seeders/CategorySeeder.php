<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bike categories
        $bikeCategories = [
            'Sport Bikes',
            'Cruisers',
            'Adventure',
            'Touring',
            'Off-road',
            'Cafe Racers',
        ];
        
        foreach ($bikeCategories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Category for ' . $category . ' motorcycles.',
                'type' => 'bikes',
            ]);
        }
        
        // Gear categories
        $gearCategories = [
            'Helmets',
            'Jackets',
            'Gloves',
            'Boots',
            'Pants',
            'Protection',
            'Accessories',
        ];
        
        foreach ($gearCategories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Category for motorcycle ' . $category . '.',
                'type' => 'gear',
            ]);
        }
    }
}
