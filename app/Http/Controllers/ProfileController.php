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
        if (!$user) {
            // User not found, clear session and redirect to login
            session()->invalidate();
            return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
        }
        
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
            'email' => 'required|email|max:255|unique:users,email,' . session('auth.user_id'),
        ], [
            'name.required' => 'Name is required',
            'name.regex' => 'Name must contain only letters and spaces',
            'name.min' => 'Name must be at least 2 characters long',
            'name.max' => 'Name is too long',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.max' => 'Email address is too long',
            'email.unique' => 'This email is already registered',
        ]);
        
        $user = User::find(session('auth.user_id'));
        if (!$user) {
            session()->invalidate();
            return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
        }
        
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            
            // Update session
            $request->session()->put('auth.name', $user->name);
            $request->session()->put('auth.email', $user->email);
            
            // Log profile update
            \Log::info('Profile updated', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip()
            ]);
            
            return back()->with('status', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Profile update failed', [
                'user_id' => session('auth.user_id'),
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.'])->withInput();
        }
    }

}
