<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of news articles.
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        $news = new News();
        $news->title = $validated['title'];
        $news->slug = Str::slug($validated['title']);
        $news->content = $validated['content'];
        $news->is_featured = $request->has('is_featured');
        $news->published_at = $validated['published_at'] ?? now();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing a news article.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        $news->title = $validated['title'];
        $news->slug = Str::slug($validated['title']);
        $news->content = $validated['content'];
        $news->is_featured = $request->has('is_featured');
        $news->published_at = $validated['published_at'] ?? $news->published_at;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            $imagePath = $request->file('image')->store('news', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }
}
