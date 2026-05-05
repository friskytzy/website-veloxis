<?php

namespace Database\Seeders;

use App\Models\SparePart;
use App\Support\VeloxisCatalog;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    public function run(): void
    {
        foreach (VeloxisCatalog::products() as $product) {
            SparePart::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'name' => $product['name'],
                    'sku' => $product['sku'],
                    'category' => $product['category'],
                    'part_brand' => $product['part_brand'],
                    'motor_brand' => $product['motor_brand'],
                    'compatible_models' => $product['models'],
                    'compatible_years' => $product['years'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'rating' => $product['rating'],
                    'review_count' => $product['review_count'],
                    'image_url' => $product['image'],
                    'description' => $product['description'],
                    'specifications' => $product['specifications'],
                    'badge' => $product['badge'],
                    'status' => 'active',
                    'is_featured' => $product['id'] <= 6,
                ]
            );
        }
    }
}
