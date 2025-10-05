<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session('auth.user_id')) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (session('auth.user_id')) {
            return redirect('/home');
        }

        // Trim all inputs to remove trailing spaces
        $request->merge([
            'email' => trim($request->input('email')),
            'password' => trim($request->input('password')),
        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters long',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $request->session()->put('auth.user_id', $user->id);
        $request->session()->put('auth.email', $user->email);
        $request->session()->put('auth.name', $user->name);
        $request->session()->put('auth.role', $user->role);

        // Handle Remember Me functionality
        if ($remember) {
            $rememberToken = $user->generateRememberToken();
            // Harden cookie: HttpOnly, Secure (honors APP_ENV), SameSite=Lax
            $minutes = 60 * 24 * 30;
            $cookie = cookie(
                name: 'remember_me',
                value: $rememberToken,
                minutes: $minutes,
                path: '/',
                domain: null,
                secure: app()->environment('production'),
                httpOnly: true,
                raw: false,
                sameSite: 'lax'
            );
            $request->session()->put('auth.remember', true);
            return redirect($user->role === 'admin' ? '/admin' : '/home')->withCookie($cookie);
        }

        return redirect($user->role === 'admin' ? '/admin' : '/home');
    }

    public function showRegisterForm()
    {
        if (session('auth.user_id')) {
            return redirect('/home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (session('auth.user_id')) {
            return redirect('/home');
        }

        // Trim all inputs to remove trailing spaces
        $request->merge([
            'name' => trim($request->input('name')),
            'email' => trim($request->input('email')),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ]);

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|min:2',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'password_confirmation' => 'required|same:password',
        ], [
            'name.required' => 'Name is required',
            'name.regex' => 'Name must contain only letters and spaces',
            'name.min' => 'Name must be at least 2 characters long',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters long',
            'password.regex' => 'Password must contain letters, numbers, and special characters',
            'password_confirmation.required' => 'Please confirm your password',
            'password_confirmation.same' => 'Password confirmation does not match',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        
        // Set role to user after creation
        $user->role = 'user';
        $user->save();

        // Log the user in immediately after registration
        $request->session()->put('auth.user_id', $user->id);
        $request->session()->put('auth.email', $user->email);
        $request->session()->put('auth.name', $user->name);
        $request->session()->put('auth.role', $user->role);

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        // Clear remember me token if user is logged in
        if ($request->session()->has('auth.user_id')) {
            $userId = $request->session()->get('auth.user_id');
            $user = User::find($userId);
            if ($user) {
                $user->clearRememberToken();
            }
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear the remember me cookie
        $cookie = cookie(
            name: 'remember_me',
            value: '',
            minutes: -1,
            path: '/',
            domain: null,
            secure: app()->environment('production'),
            httpOnly: true,
            raw: false,
            sameSite: 'lax'
        );

        return redirect('/')->withCookie($cookie);
    }
}
