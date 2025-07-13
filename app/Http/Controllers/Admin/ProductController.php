<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Gear;
use App\Models\Category;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BikeStoreRequest;
use App\Http\Requests\GearStoreRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of bikes.
     */
    public function bikes()
    {
        $bikes = Bike::paginate(10);
        return view('admin.products.bikes.index', compact('bikes'));
    }

    /**
     * Display a listing of gear.
     */
    public function gear()
    {
        $gear = Gear::paginate(10);
        return view('admin.products.gear.index', compact('gear'));
    }

    /**
     * Show the form for creating a new bike.
     */
    public function createBike()
    {
        $categories = Category::where('type', 'bikes')->get();
        return view('admin.products.bikes.create', compact('categories'));
    }

    /**
     * Show the form for creating a new gear.
     */
    public function createGear()
    {
        $categories = Category::where('type', 'gear')->get();
        return view('admin.products.gear.create', compact('categories'));
    }

    /**
     * Store a newly created bike.
     */
    public function storeBike(BikeStoreRequest $request)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid('bike_').'.'.$image->getClientOriginalExtension();
            $resized = Image::read($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            Storage::disk('public')->put('bikes/'.$filename, $resized);
            $imagePath = 'bikes/'.$filename;
        }

        // Get the category ID from the selected category name
        $category = Category::where('name', $validated['category'])->where('type', 'bikes')->first();
        $category_id = $category ? $category->id : null;
        
        Bike::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'category_id' => $category_id,
            'stock' => $validated['stock'],
            'image' => $imagePath, // Will be null if no image was uploaded
            'specifications' => $validated['specifications'] ?? [],
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('admin.products.bikes')->with('success', 'Bike berhasil ditambahkan!');
    }

    /**
     * Store a newly created gear.
     */
    public function storeGear(GearStoreRequest $request)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid('gear_').'.'.$image->getClientOriginalExtension();
            $resized = Image::read($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            Storage::disk('public')->put('gear/'.$filename, $resized);
            $imagePath = 'gear/'.$filename;
        }

        // Handle empty strings as null for size and color
        $size = !empty($validated['size']) ? $validated['size'] : null;
        $color = !empty($validated['color']) ? $validated['color'] : null;
        
        // Get the category ID from the selected category name
        $category = Category::where('name', $validated['category'])->where('type', 'gear')->first();
        $category_id = $category ? $category->id : null;

        Gear::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'category_id' => $category_id,
            'stock' => $validated['stock'],
            'size' => $size,
            'color' => $color,
            'image' => $imagePath,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('admin.products.gear')->with('success', 'Gear berhasil ditambahkan!');
    }
    
    /**
     * Show the form for editing a bike.
     */
    public function editBike(Bike $bike)
    {
        $categories = Category::where('type', 'bikes')->get();
        return view('admin.products.bikes.edit', compact('bike', 'categories'));
    }
    
    /**
     * Show the form for editing a gear.
     */
    public function editGear(Gear $gear)
    {
        $categories = Category::where('type', 'gear')->get();
        return view('admin.products.gear.edit', compact('gear', 'categories'));
    }
    
    /**
     * Update the specified bike.
     */
    public function updateBike(BikeStoreRequest $request, Bike $bike)
    {
        $validated = $request->validated();
        
        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'stock' => $validated['stock'],
            'specifications' => $validated['specifications'] ?? [],
            'is_featured' => $validated['is_featured'] ?? false,
        ];
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bike->image) {
                Storage::disk('public')->delete($bike->image);
            }
            
            $image = $request->file('image');
            $filename = uniqid('bike_').'.'.$image->getClientOriginalExtension();
            $resized = Image::read($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            Storage::disk('public')->put('bikes/'.$filename, $resized);
            $updateData['image'] = 'bikes/'.$filename;
        }
        
        $bike->update($updateData);
        
        return redirect()->route('admin.products.bikes')->with('success', 'Bike berhasil diperbarui!');
    }
    
    /**
     * Update the specified gear.
     */
    public function updateGear(GearStoreRequest $request, Gear $gear)
    {
        $validated = $request->validated();
        
        // Handle empty strings as null for size and color
        $size = !empty($validated['size']) ? $validated['size'] : null;
        $color = !empty($validated['color']) ? $validated['color'] : null;
        
        // Get the category ID from the selected category name
        $category = Category::where('name', $validated['category'])->where('type', 'gear')->first();
        $category_id = $category ? $category->id : null;
        
        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'category_id' => $category_id,
            'stock' => $validated['stock'],
            'size' => $size,
            'color' => $color,
            'is_featured' => $validated['is_featured'] ?? false,
        ];
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gear->image) {
                Storage::disk('public')->delete($gear->image);
            }
            
            $image = $request->file('image');
            $filename = uniqid('gear_').'.'.$image->getClientOriginalExtension();
            $resized = Image::read($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            Storage::disk('public')->put('gear/'.$filename, $resized);
            $updateData['image'] = 'gear/'.$filename;
        }
        
        $gear->update($updateData);
        
        return redirect()->route('admin.products.gear')->with('success', 'Gear berhasil diperbarui!');
    }
    
    /**
     * Remove the specified bike.
     */
    public function destroyBike(Bike $bike)
    {
        // Delete image if exists
        if ($bike->image) {
            Storage::disk('public')->delete($bike->image);
        }
        
        $bike->delete();
        
        return redirect()->route('admin.products.bikes')->with('success', 'Bike berhasil dihapus!');
    }
    
    /**
     * Remove the specified gear.
     */
    public function destroyGear(Gear $gear)
    {
        // Delete image if exists
        if ($gear->image) {
            Storage::disk('public')->delete($gear->image);
        }
        
        $gear->delete();
        
        return redirect()->route('admin.products.gear')->with('success', 'Gear berhasil dihapus!');
    }
}
