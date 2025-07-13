<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Gear;
use App\Models\News;
use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $featuredBikes = Bike::where('is_featured', true)->take(6)->get();
        $featuredGear = Gear::where('is_featured', true)->take(4)->orderBy('created_at', 'desc')->get();
        $latestNews = News::where('is_published', true)->latest()->take(3)->get();
        $upcomingEvents = Event::where('start_date', '>=', now())->orderBy('start_date')->take(3)->get();

        return view('home', compact('featuredBikes', 'featuredGear', 'latestNews', 'upcomingEvents'));
    }
}
