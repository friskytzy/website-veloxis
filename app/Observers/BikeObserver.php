<?php

namespace App\Observers;

use App\Models\Bike;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BikeObserver
{
    /**
     * Handle the Bike "creating" event.
     */
    public function creating(Bike $bike): void
    {
        // Only assign a default image if none is provided
        if (empty($bike->image)) {
            $this->assignDefaultImage($bike);
        }
    }

    /**
     * Handle the Bike "created" event.
     */
    public function created(Bike $bike): void
    {
        //
    }

    /**
     * Handle the Bike "updated" event.
     */
    public function updated(Bike $bike): void
    {
        //
    }

    /**
     * Handle the Bike "deleted" event.
     */
    public function deleted(Bike $bike): void
    {
        //
    }

    /**
     * Handle the Bike "restored" event.
     */
    public function restored(Bike $bike): void
    {
        //
    }

    /**
     * Handle the Bike "force deleted" event.
     */
    public function forceDeleted(Bike $bike): void
    {
        //
    }

    /**
     * Assign a default image to a bike based on its category.
     */
    private function assignDefaultImage(Bike $bike): void
    {
        // Default images for each category
        $categoryImages = [
            'Sport' => 'sport-bike.jpg',
            'Cruiser' => 'cruiser-bike.jpg',
            'Touring' => 'touring-bike.jpg',
            'Off-Road' => 'off-road-bike.jpg',
            'Scooter' => 'scooter-bike.jpg',
            'Street' => 'street-bike.jpg',
        ];
        
        // Get color based on category
        $categoryColors = [
            'Sport' => '#ff3333',     // Red
            'Cruiser' => '#3366cc',   // Blue
            'Touring' => '#339966',   // Green
            'Off-Road' => '#cc6600',  // Brown
            'Scooter' => '#9933cc',   // Purple
            'Street' => '#ff9900',    // Orange
        ];
        
        $backgroundColor = $categoryColors[$bike->category] ?? '#' . Str::random(6);

        // Check if we have a default image for the bike's category
        $defaultImageName = $categoryImages[$bike->category] ?? 'default-bike.jpg';

        // Path to default images directory
        $defaultImagesPath = public_path('images/defaults');
        
        // Check if the default image exists, if not generate a new one
        $sourcePath = File::exists("$defaultImagesPath/$defaultImageName") 
            ? "$defaultImagesPath/$defaultImageName"
            : null;

        // If we don't have an appropriate image, generate one
        if (!$sourcePath) {
            // Create directory if it doesn't exist
            if (!File::exists($defaultImagesPath)) {
                File::makeDirectory($defaultImagesPath, 0755, true);
            }
            
            // Generate a simple colored placeholder image (800x600px) with the background color
            $width = 800;
            $height = 600;
            
            // Create a new image with GD
            $img = imagecreatetruecolor($width, $height);
            
            // Convert the hex color to RGB
            $hex = ltrim($backgroundColor, '#');
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            
            // Allocate the background color
            $bgColor = imagecolorallocate($img, $r, $g, $b);
            imagefill($img, 0, 0, $bgColor);
            
            // Set text color (white)
            $textColor = imagecolorallocate($img, 255, 255, 255);
            
            // Write text - using built-in GD font (font 5 is the largest)
            // Brand name
            $brand = 'VELOXIS';
            $fontsize = 5; // largest built-in font
            imagestring($img, $fontsize, 350, 200, $brand, $textColor);
            
            // Category name
            if ($bike->category) {
                $category = strtoupper($bike->category);
                imagestring($img, $fontsize, 350, 250, $category, $textColor);
            }
            
            // Model name
            $model = Str::limit($bike->name, 20);
            imagestring($img, $fontsize, 350, 300, $model, $textColor);
            
            // Create a temporary file name for this specific bike
            $generatedFileName = 'default-' . Str::slug($bike->category ?? 'bike') . '.jpg';
            $sourcePath = "$defaultImagesPath/$generatedFileName";
            
            // Save the image as JPG
            imagejpeg($img, $sourcePath, 90);
            imagedestroy($img);
        }

        // Copy the image to storage
        $filename = 'bikes/' . uniqid('bike_') . '.jpg';
        
        // Read the source image and resize
        $imgContent = file_get_contents($sourcePath);
        Storage::disk('public')->put($filename, $imgContent);
        
        // Set the image path
        $bike->image = $filename;
    }
}
