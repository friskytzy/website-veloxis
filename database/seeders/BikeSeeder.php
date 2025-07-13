<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bike;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bikes = [
            [
                'name' => 'Harley-Davidson Street Glide',
                'description' => 'The iconic touring motorcycle with premium comfort and classic Harley styling.',
                'price' => 25000000,
                'category' => 'Classic Cruiser',
                'image' => 'bikes/harley-street-glide.jpg',
                'specifications' => [
                    'engine' => 'Milwaukee-Eight 107',
                    'displacement' => '1746cc',
                    'power' => '86 hp',
                    'torque' => '150 Nm',
                    'transmission' => '6-speed',
                    'fuel_capacity' => '22.7L',
                    'weight' => '363 kg'
                ],
                'stock' => 5,
                'is_featured' => true,
            ],
            [
                'name' => 'Honda CBR1000RR',
                'description' => 'Track-ready sportbike with cutting-edge technology and aggressive styling.',
                'price' => 35000000,
                'category' => 'Sport Bike',
                'image' => 'bikes/honda-cbr1000rr.jpg',
                'specifications' => [
                    'engine' => '999.9cc Inline-4',
                    'displacement' => '999.9cc',
                    'power' => '160 hp',
                    'torque' => '113 Nm',
                    'transmission' => '6-speed',
                    'fuel_capacity' => '16.1L',
                    'weight' => '201 kg'
                ],
                'stock' => 3,
                'is_featured' => true,
            ],
            [
                'name' => 'BMW R 1250 GS',
                'description' => 'The ultimate adventure motorcycle for exploring any terrain.',
                'price' => 45000000,
                'category' => 'Adventure',
                'image' => 'bikes/bmw-r1250gs.jpg',
                'specifications' => [
                    'engine' => 'Boxer Twin',
                    'displacement' => '1254cc',
                    'power' => '136 hp',
                    'torque' => '143 Nm',
                    'transmission' => '6-speed',
                    'fuel_capacity' => '20L',
                    'weight' => '249 kg'
                ],
                'stock' => 4,
                'is_featured' => false,
            ],
            [
                'name' => 'Zero SR/F',
                'description' => 'Electric motorcycle with instant torque and zero emissions.',
                'price' => 55000000,
                'category' => 'Electric',
                'image' => 'bikes/zero-srf.jpg',
                'specifications' => [
                    'engine' => 'Z-Force 75-10',
                    'battery' => '14.4 kWh',
                    'power' => '110 hp',
                    'torque' => '190 Nm',
                    'range' => '257 km',
                    'charging_time' => '2.5 hours',
                    'weight' => '220 kg'
                ],
                'stock' => 2,
                'is_featured' => true,
            ],
            [
                'name' => 'Triumph Bonneville T120',
                'description' => 'Classic British styling with modern performance and reliability.',
                'price' => 28000000,
                'category' => 'Vintage',
                'image' => 'bikes/triumph-bonneville.jpg',
                'specifications' => [
                    'engine' => 'Parallel Twin',
                    'displacement' => '1200cc',
                    'power' => '79 hp',
                    'torque' => '105 Nm',
                    'transmission' => '6-speed',
                    'fuel_capacity' => '14.5L',
                    'weight' => '224 kg'
                ],
                'stock' => 6,
                'is_featured' => false,
            ],
            [
                'name' => 'Custom Chopper "Road King"',
                'description' => 'Hand-built custom chopper with unique styling and powerful V-twin engine.',
                'price' => 75000000,
                'category' => 'Custom Chopper',
                'image' => 'bikes/custom-chopper.jpg',
                'specifications' => [
                    'engine' => 'Custom V-Twin',
                    'displacement' => '1800cc',
                    'power' => '95 hp',
                    'torque' => '160 Nm',
                    'transmission' => '6-speed',
                    'fuel_capacity' => '18L',
                    'weight' => '320 kg'
                ],
                'stock' => 1,
                'is_featured' => true,
            ],
        ];

        foreach ($bikes as $bike) {
            Bike::create($bike);
        }
    }
}
