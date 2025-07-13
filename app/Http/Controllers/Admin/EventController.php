<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        // Dapatkan event menggunakan query builder untuk kompatibilitas dengan struktur tabel
        $events = DB::table('events')
            ->select('id', 'title', 'location', 'start_date', 'image')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'registration_link' => 'nullable|url|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        // Gunakan query builder untuk kompatibilitas
        DB::table('events')->insert([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'],
            'max_participants' => $validated['max_participants'] ?? null,
            'is_featured' => $validated['is_featured'] ?? false,
            'registration_link' => $validated['registration_link'] ?? null,
            'image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit($id)
    {
        $event = DB::table('events')->find($id);
        
        if (!$event) {
            abort(404);
        }
        
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, $id)
    {
        $event = DB::table('events')->find($id);
        
        if (!$event) {
            abort(404);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_participants' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'registration_link' => 'nullable|url|max:255',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'location' => $validated['location'],
            'max_participants' => $validated['max_participants'] ?? null,
            'is_featured' => $validated['is_featured'] ?? false,
            'registration_link' => $validated['registration_link'] ?? null,
            'updated_at' => now(),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $updateData['image'] = $request->file('image')->store('events', 'public');
        }

        DB::table('events')->where('id', $id)->update($updateData);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy($id)
    {
        $event = DB::table('events')->find($id);
        
        if (!$event) {
            abort(404);
        }
        
        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        DB::table('events')->delete($id);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
