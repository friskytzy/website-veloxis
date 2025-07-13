<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Requests\ContactStoreRequest;

class ContactController extends Controller
{
    /**
     * Display contact form.
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store contact message.
     */
    public function store(ContactStoreRequest $request)
    {
        $validated = $request->validated();
        
        // Store contact message (you can create a Contact model if needed)
        // For now, we'll just return success
        
        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}
