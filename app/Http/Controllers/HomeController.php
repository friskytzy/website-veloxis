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
        return view('home');
    }
}
