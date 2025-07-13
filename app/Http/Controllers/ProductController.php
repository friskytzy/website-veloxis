<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Gear;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display bikes catalog with search and filter.
     */
    public function bikes(Request $request)
    {
        $query = Bike::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Featured filter
        if ($request->has('featured')) {
            $query->where('is_featured', true);
        }
        
        $bikes = $query->paginate(12);
        $categories = Category::where('type', 'bikes')->get();
        
        return view('products.bikes', compact('bikes', 'categories'));
    }

    /**
     * Display gear catalog with search and filter.
     */
    public function gear(Request $request)
    {
        $query = Gear::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Price filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Size filter
        if ($request->has('size') && $request->size) {
            $query->where('size', $request->size);
        }
        
        $gear = $query->paginate(12);
        $categories = Category::where('type', 'gear')->get();
        
        return view('products.gear', compact('gear', 'categories'));
    }

    /**
     * Display bike detail.
     */
    public function showBike(Bike $bike)
    {
        $relatedBikes = Bike::where('category', $bike->category)
                            ->where('id', '!=', $bike->id)
                            ->take(3)
                            ->get();
        
        return view('products.bike-detail', compact('bike', 'relatedBikes'));
    }

    /**
     * Display gear detail.
     */
    public function showGear(Gear $gear)
    {
        $relatedGear = Gear::where('category', $gear->category)
                           ->where('id', '!=', $gear->id)
                           ->take(3)
                           ->get();
        
        return view('products.gear-detail', compact('gear', 'relatedGear'));
    }
}
