<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:bikes,gear',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? null;
        $category->parent_id = $validated['parent_id'] ?? null;
        $category->type = $validated['type'];
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'type' => 'required|in:bikes,gear',
        ]);

        // Prevent category from becoming its own parent
        if (!empty($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'A category cannot be its own parent.'])
                ->withInput();
        }

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'] ?? $category->description;
        $category->parent_id = $validated['parent_id'] ?? $category->parent_id;
        $category->type = $validated['type'];
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with associated products.');
        }
        
        // Handle sub-categories before deleting
        if ($category->children()->count() > 0) {
            // Option 1: Move children to parent
            if ($category->parent_id) {
                foreach ($category->children as $child) {
                    $child->parent_id = $category->parent_id;
                    $child->save();
                }
            } 
            // Option 2: Make children top-level
            else {
                foreach ($category->children as $child) {
                    $child->parent_id = null;
                    $child->save();
                }
            }
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
