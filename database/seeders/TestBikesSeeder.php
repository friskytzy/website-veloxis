<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bike;
use App\Models\Category;

class TestBikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have bike categories
        $categories = ['Sport', 'Cruiser', 'Touring', 'Off-Road', 'Scooter', 'Street'];
        
        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category, 'type' => 'bikes'],
                ['description' => "Category for {$category} bikes"]
            );
        }
        
        // Create test bikes with no images, to test automatic image assignment
        $bikes = [
            [
                'name' => 'Veloxis Thunderbolt X1',
                'description' => 'A powerful sport bike with cutting-edge technology and aerodynamic design.',
                'price' => 25000000,
                'category' => 'Sport',
                'stock' => 10,
                'specifications' => [
                    'engine' => '1000cc',
                    'power' => '180 HP',
                    'torque' => '95 Nm',
                    'weight' => '190 kg',
                    'fuel_capacity' => '18 L'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Veloxis Cruiser King',
                'description' => 'Comfortable cruiser bike perfect for long rides on the open road.',
                'price' => 32000000,
                'category' => 'Cruiser',
                'stock' => 5,
                'specifications' => [
                    'engine' => '1600cc',
                    'power' => '95 HP',
                    'torque' => '150 Nm',
                    'weight' => '320 kg',
                    'fuel_capacity' => '22 L'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'Veloxis Adventure Pro',
                'description' => 'Ultimate touring bike for adventures across any terrain.',
                'price' => 40000000,
                'category' => 'Touring',
                'stock' => 3,
                'specifications' => [
                    'engine' => '1200cc',
                    'power' => '140 HP',
                    'torque' => '120 Nm',
                    'weight' => '230 kg',
                    'fuel_capacity' => '25 L'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Veloxis Dirt Devil',
                'description' => 'Lightweight off-road bike designed for ultimate trail performance.',
                'price' => 15000000,
                'category' => 'Off-Road',
                'stock' => 15,
                'specifications' => [
                    'engine' => '450cc',
                    'power' => '55 HP',
                    'torque' => '45 Nm',
                    'weight' => '110 kg',
                    'fuel_capacity' => '10 L'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'Veloxis City Glider',
                'description' => 'Efficient and stylish scooter for urban commuting.',
                'price' => 12000000,
                'category' => 'Scooter',
                'stock' => 20,
                'specifications' => [
                    'engine' => '150cc',
                    'power' => '15 HP',
                    'torque' => '14 Nm',
                    'weight' => '95 kg',
                    'fuel_capacity' => '8 L'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Veloxis Street Fighter',
                'description' => 'Aggressive street bike with precision handling and raw power.',
                'price' => 22000000,
                'category' => 'Street',
                'stock' => 8,
                'specifications' => [
                    'engine' => '900cc',
                    'power' => '120 HP',
                    'torque' => '90 Nm',
                    'weight' => '180 kg',
                    'fuel_capacity' => '16 L'
                ],
                'is_featured' => false
            ],
        ];
        
        // Create bikes without images to test automatic image assignment
        foreach ($bikes as $bikeData) {
            // Get category_id
            $category = Category::where('name', $bikeData['category'])
                               ->where('type', 'bikes')
                               ->first();
            
            if ($category) {
                $bikeData['category_id'] = $category->id;
            }
            
            // Create bike without an image
            Bike::create($bikeData);
        }
        
        $this->command->info('Created ' . count($bikes) . ' bikes with automatic image assignment.');
    }
}
