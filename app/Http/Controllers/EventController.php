<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display events listing.
     */
    public function index()
    {
        $events = DB::table('events')
                ->where('start_date', '>=', now())
                ->orderBy('start_date')
                ->paginate(9);
        
        return view('events.index', compact('events'));
    }

    /**
     * Display event detail.
     */
    public function show($id)
    {
        $event = DB::table('events')->find($id);
        
        if (!$event) {
            abort(404);
        }
        
        $relatedEvents = DB::table('events')
                ->where('start_date', '>=', now())
                ->where('id', '!=', $id)
                ->orderBy('start_date')
                ->limit(3)
                ->get();
        
        return view('events.show', compact('event', 'relatedEvents'));
    }
}
