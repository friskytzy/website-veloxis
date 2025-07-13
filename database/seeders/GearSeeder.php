<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gear;

class GearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test Gear 1 - with size and color
        Gear::create([
            'name' => 'Test Riding Jacket',
            'description' => 'A high quality riding jacket for all seasons.',
            'price' => 750000,
            'category' => 'Apparel',
            'image' => 'gear/test_jacket.jpg',
            'size' => 'L',
            'color' => 'Black',
            'stock' => 5,
            'is_featured' => true,
        ]);

        // Test Gear 2 - without size and color (should work after our fix)
        Gear::create([
            'name' => 'Premium Helmet',
            'description' => 'A premium helmet with excellent protection.',
            'price' => 1200000,
            'category' => 'Helmets',
            'image' => 'gear/test_helmet.jpg',
            'size' => null,
            'color' => null,
            'stock' => 3,
            'is_featured' => true,
        ]);
    }
}
