<?php

namespace App\Http\Controllers;

use App\Models\Gear;
use App\Models\Category;
use Illuminate\Http\Request;

class GearController extends Controller
{
    /**
     * Display a listing of the gear.
     */
    public function index(Request $request)
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
        if ($request->has('price_range') && $request->price_range) {
            $range = explode('-', $request->price_range);
            if (count($range) == 2) {
                $query->whereBetween('price', [$range[0], $range[1]]);
            } elseif ($request->price_range == '5000000+') {
                $query->where('price', '>=', 5000000);
            }
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
     * Display the specified gear.
     */
    public function show(Gear $gear)
    {
        $relatedGear = Gear::where('category', $gear->category)
                           ->where('id', '!=', $gear->id)
                           ->take(4)
                           ->get();
        
        return view('products.gear-detail', compact('gear', 'relatedGear'));
    }
}
