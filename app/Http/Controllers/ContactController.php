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
            'name' => 'required|string|max:255|min:2|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255|min:5',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 2 characters',
            'name.regex' => 'Name must contain only letters and spaces',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'subject.required' => 'Subject is required',
            'subject.min' => 'Subject must be at least 5 characters',
            'message.required' => 'Message is required',
            'message.min' => 'Message must be at least 10 characters',
            'message.max' => 'Message is too long (maximum 2000 characters)',
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
