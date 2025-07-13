<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Harley-Davidson Announces New Electric Lineup',
                'content' => 'Harley-Davidson has unveiled its latest electric motorcycle lineup, featuring the new LiveWire S2 Del Mar. This revolutionary electric bike combines classic Harley styling with cutting-edge electric technology, offering riders a sustainable and powerful riding experience.',
                'image' => 'news/harley-electric.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
            [
                'title' => 'BMW Motorrad Celebrates 100 Years of Innovation',
                'content' => 'BMW Motorrad is celebrating its centenary with a series of special events and limited-edition motorcycles. The company has been at the forefront of motorcycle innovation for a century, from the iconic R32 to the latest electric models.',
                'image' => 'news/bmw-100-years.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
            [
                'title' => 'Ducati Dominates MotoGP Championship',
                'content' => 'Ducati has secured another MotoGP championship title, with their riders dominating the season. The Italian manufacturer\'s commitment to racing excellence continues to push the boundaries of motorcycle performance.',
                'image' => 'news/ducati-motogp.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
            [
                'title' => 'Adventure Riding: The Ultimate Guide to Off-Road Motorcycling',
                'content' => 'Discover the thrill of adventure riding with our comprehensive guide to off-road motorcycling. From essential gear to advanced techniques, learn everything you need to know about exploring the world on two wheels.',
                'image' => 'news/adventure-riding.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
            [
                'title' => 'Electric Motorcycles: The Future of Riding',
                'content' => 'Electric motorcycles are revolutionizing the industry with their instant torque, zero emissions, and low maintenance requirements. Major manufacturers are investing heavily in electric technology, signaling a shift toward sustainable transportation.',
                'image' => 'news/electric-future.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
            [
                'title' => 'Custom Motorcycle Culture: Art on Two Wheels',
                'content' => 'Custom motorcycle culture continues to thrive, with builders creating unique works of art on two wheels. From choppers to café racers, custom bikes represent the ultimate expression of personal style and mechanical creativity.',
                'image' => 'news/custom-culture.jpg',
                'author' => 'Veloxis Team',
                'is_published' => true,
            ],
        ];

        foreach ($news as $article) {
            News::create($article);
        }
    }
}
