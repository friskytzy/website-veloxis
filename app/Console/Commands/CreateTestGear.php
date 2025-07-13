<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gear;
use App\Models\Category;

class CreateTestGear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-gear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test gear data for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create gear categories if they don't exist
        $this->createCategories();
        
        // Create test gear item
        $this->createTestGear();
        
        $this->info('Test gear items created successfully!');
    }
    
    /**
     * Create required categories for gear
     */
    private function createCategories()
    {
        $categories = [
            'Helmets',
            'Jackets',
            'Gloves',
            'Boots'
        ];
        
        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName, 'type' => 'gear'],
                [
                    'description' => 'Category for ' . $categoryName,
                    'slug' => strtolower(str_replace(' ', '-', $categoryName))
                ]
            );
        }
        
        $this->info('Categories created successfully!');
    }
    
    /**
     * Create test gear items
     */
    private function createTestGear()
    {
        // Get a category ID for the gear
        $category = Category::where('type', 'gear')->first();
        
        if (!$category) {
            $this->error('No gear categories found! Creating one now...');
            $category = Category::create([
                'name' => 'Test Category',
                'type' => 'gear',
                'description' => 'Test gear category',
                'slug' => 'test-category'
            ]);
        }
        
        // Test Gear 1 (with size and color)
        Gear::create([
            'name' => 'Test Riding Jacket',
            'description' => 'A high quality riding jacket for all seasons.',
            'price' => 750000,
            'category' => $category->name,
            'category_id' => $category->id,
            'image' => 'gear/test_jacket.jpg', // Note: This file doesn't actually exist
            'size' => 'L',
            'color' => 'Black',
            'stock' => 5,
            'is_featured' => true,
        ]);
        
        // Test Gear 2 (without size and color)
        Gear::create([
            'name' => 'Premium Helmet',
            'description' => 'A premium helmet with excellent protection.',
            'price' => 1200000,
            'category' => $category->name,
            'category_id' => $category->id,
            'image' => 'gear/test_helmet.jpg', // Note: This file doesn't actually exist
            'size' => null,
            'color' => null,
            'stock' => 3,
            'is_featured' => true,
        ]);
        
        $this->info('Test gear items created!');
    }
} 