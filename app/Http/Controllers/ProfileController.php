<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }
        $user = User::find(session('auth.user_id'));
        return view('profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }
        
        // Trim all inputs to remove trailing spaces
        $request->merge([
            'name' => trim($request->input('name')),
            'email' => trim($request->input('email')),
        ]);
        
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|min:2',
            'email' => 'required|email|max:255',
        ], [
            'name.required' => 'Name is required',
            'name.regex' => 'Name must contain only letters and spaces',
            'name.min' => 'Name must be at least 2 characters long',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
        ]);
        
        $user = User::find(session('auth.user_id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        
        // Update session
        $request->session()->put('auth.name', $user->name);
        $request->session()->put('auth.email', $user->email);
        
        return back()->with('status', 'Profile updated successfully!');
    }

}
