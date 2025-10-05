<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        // Check if user is logged in
        if (!session('auth.user_id')) {
            return redirect('/login')->with('error', 'Please log in to contact us.');
        }
        
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'user_id' => session('auth.user_id'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'content' => $request->input('message'),
        ]);

        return redirect('/contact')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }
}
