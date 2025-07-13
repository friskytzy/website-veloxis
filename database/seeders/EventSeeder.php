<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Monthly Community Ride',
            'description' => 'Join our monthly rides and meet fellow riders who share your passion. This scenic route takes us through beautiful countryside with stops at local cafes and viewpoints.',
            'date' => '2024-08-15',
            'location' => 'Veloxis Showroom - Downtown',
            'max_participants' => 50,
            'image' => 'https://storage.googleapis.com/a1aa/image/d12cb247-0d44-45e2-2619-aa1c3c00f5fe.jpg',
        ]);

        Event::create([
            'title' => 'Motorcycle Maintenance Workshop',
            'description' => 'Learn maintenance, customization, and repair skills from the pros. This hands-on workshop covers basic maintenance, oil changes, brake service, and more.',
            'date' => '2024-08-22',
            'location' => 'Veloxis Service Center',
            'max_participants' => 20,
            'image' => 'https://storage.googleapis.com/a1aa/image/98ce8684-c85b-4fd0-2b56-b01af7483b56.jpg',
        ]);

        Event::create([
            'title' => 'Safety Riding Course',
            'description' => 'Advanced safety course for experienced riders. Learn defensive riding techniques, emergency braking, and advanced cornering skills.',
            'date' => '2024-09-05',
            'location' => 'Veloxis Training Track',
            'max_participants' => 15,
            'image' => 'https://storage.googleapis.com/a1aa/image/3b60dd31-083a-4a06-4be0-4bd96fe00c5d.jpg',
        ]);

        Event::create([
            'title' => 'Custom Bike Show',
            'description' => 'Annual custom motorcycle show featuring the best custom builds from local and international builders. Awards for best in class categories.',
            'date' => '2024-09-20',
            'location' => 'Veloxis Legends Arena',
            'max_participants' => 200,
            'image' => 'https://storage.googleapis.com/a1aa/image/000d31a5-f4e1-4843-7866-c5c1dbbc8910.jpg',
        ]);

        Event::create([
            'title' => 'Electric Motorcycle Demo Day',
            'description' => 'Test ride our latest electric motorcycles and learn about the future of sustainable riding. Free test rides available for licensed riders.',
            'date' => '2024-10-10',
            'location' => 'Veloxis Electric Showroom',
            'max_participants' => 30,
            'image' => 'https://storage.googleapis.com/a1aa/image/fa34b9a8-4805-4e38-9ede-9fba1f887dce.jpg',
        ]);
    }
}
