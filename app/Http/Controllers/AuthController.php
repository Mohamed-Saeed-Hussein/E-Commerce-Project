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
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.max' => 'Email address is too long',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters long',
            'password.max' => 'Password is too long',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // Rate limiting check (additional to route middleware)
        $key = 'login_attempts_' . $request->ip();
        $attempts = cache()->get($key, 0);
        if ($attempts >= 5) {
            \Log::warning('Login rate limit exceeded', [
                'ip' => $request->ip(),
                'email' => $email,
                'attempts' => $attempts
            ]);
            return back()->withErrors(['email' => 'Too many login attempts. Please try again later.'])->withInput();
        }

        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            // Increment failed attempts
            cache()->put($key, $attempts + 1, 300); // 5 minutes
            
            \Log::warning('Failed login attempt', [
                'ip' => $request->ip(),
                'email' => $email,
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Clear failed attempts on successful login
        cache()->forget($key);

        // Regenerate session ID for security
        $request->session()->regenerate();

        $request->session()->put('auth.user_id', $user->id);
        $request->session()->put('auth.email', $user->email);
        $request->session()->put('auth.name', $user->name);
        $request->session()->put('auth.role', $user->role);
        $request->session()->put('auth.last_activity', time());

        // Merge guest cart into user cart on login
        try {
            $guestCart = $request->session()->get('guest_cart', []);
            if (!empty($guestCart)) {
                foreach ($guestCart as $item) {
                    $pid = (int)($item['product_id'] ?? 0);
                    $qty = (int)($item['quantity'] ?? 0);
                    if ($pid > 0 && $qty > 0) {
                        // No stock change on merge here (stock already reserved at add time)
                        \App\Models\Cart::addToCart($user->id, $pid, $qty, (float)($item['price'] ?? 0));
                    }
                }
                $request->session()->forget('guest_cart');
            }
        } catch (\Throwable $e) {
            \Log::error('Failed merging guest cart', ['user_id' => $user->id, 'error' => $e->getMessage()]);
        }

        // Log successful login
        \Log::info('Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'remember' => $remember
        ]);

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
            'password' => 'required|min:8|max:255|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'password_confirmation' => 'required|same:password',
        ], [
            'name.required' => 'Name is required',
            'name.regex' => 'Name must contain only letters and spaces',
            'name.min' => 'Name must be at least 2 characters long',
            'name.max' => 'Name is too long',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'email.max' => 'Email address is too long',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters long',
            'password.max' => 'Password is too long',
            'password.regex' => 'Password must contain letters, numbers, and special characters',
            'password_confirmation.required' => 'Please confirm your password',
            'password_confirmation.same' => 'Password confirmation does not match',
        ]);

        // Rate limiting for registration
        $key = 'register_attempts_' . $request->ip();
        $attempts = cache()->get($key, 0);
        if ($attempts >= 3) {
            \Log::warning('Registration rate limit exceeded', [
                'ip' => $request->ip(),
                'email' => $request->input('email')
            ]);
            return back()->withErrors(['email' => 'Too many registration attempts. Please try again later.'])->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'user', // Explicitly set role
            ]);

            // Clear failed attempts on successful registration
            cache()->forget($key);

            // Regenerate session ID for security
            $request->session()->regenerate();

            // Log the user in immediately after registration
            $request->session()->put('auth.user_id', $user->id);
            $request->session()->put('auth.email', $user->email);
            $request->session()->put('auth.name', $user->name);
            $request->session()->put('auth.role', $user->role);
            $request->session()->put('auth.last_activity', time());

            // Log successful registration
            \Log::info('Successful registration', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect('/home')->with('success', 'Registration successful! Welcome to our store.');
        } catch (\Exception $e) {
            // Increment failed attempts
            cache()->put($key, $attempts + 1, 300); // 5 minutes
            
            \Log::error('Registration failed', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        // Log logout for security auditing
        if ($request->session()->has('auth.user_id')) {
            $userId = $request->session()->get('auth.user_id');
            \Log::info('User logout', [
                'user_id' => $userId,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // Clear remember me token if user is logged in
            $user = User::find($userId);
            if ($user) {
                $user->clearRememberToken();
            }
        }
        
        // Invalidate session completely
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

        return redirect('/')->with('success', 'You have been logged out successfully.')->withCookie($cookie);
    }
}
