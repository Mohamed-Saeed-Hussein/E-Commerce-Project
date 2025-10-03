<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'user_id' => session('auth.user_id'),
            'name' => 'Anonymous User',
            'email' => 'contact@stylehaven.com',
            'subject' => $request->input('subject'),
            'content' => $request->input('message'),
        ]);

        return redirect('/success');
    }
}
