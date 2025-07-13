<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Requests\NewsStoreRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class NewsController extends Controller
{
    /**
     * Display news listing.
     */
    public function index()
    {
        $news = News::where('is_published', true)
                   ->latest()
                   ->paginate(9);
        
        return view('news.index', compact('news'));
    }

    /**
     * Display news detail.
     */
    public function show(News $news)
    {
        if (!$news->is_published) {
            abort(404);
        }
        
        $relatedNews = News::where('is_published', true)
                          ->where('id', '!=', $news->id)
                          ->latest()
                          ->take(3)
                          ->get();
        
        return view('news.show', compact('news', 'relatedNews'));
    }

    public function store(NewsStoreRequest $request)
    {
        $validated = $request->validated();
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid('news_').'.'.$image->getClientOriginalExtension();
            $resized = Image::read($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
            Storage::disk('public')->put('news/'.$filename, $resized);
            $imagePath = 'news/'.$filename;
        }

        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'author' => $validated['author'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan!');
    }
}
