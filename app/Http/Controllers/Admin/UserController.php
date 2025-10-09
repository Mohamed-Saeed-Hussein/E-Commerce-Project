<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user', // Default role is always 'user'
        ]);

        return redirect('/admin/users')->with('status', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Role is not updated - remains unchanged
        ]);

        return redirect('/admin/users')->with('status', 'User updated successfully!');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === session('auth.user_id')) {
            return redirect('/admin/users')->with('error', 'You cannot delete your own account!');
        }
        
        // Set user_id to null for all orders to preserve transaction data
        \App\Models\Order::where('user_id', $user->id)->update(['user_id' => null]);
        
        // Clear any remember me tokens
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }
        
        // Log the deletion
        \Log::info('User deleted by admin', [
            'deleted_user_id' => $user->id,
            'deleted_user_email' => $user->email,
            'admin_user_id' => session('auth.user_id'),
            'timestamp' => now()
        ]);
        
        $user->delete();
        
        return redirect('/admin/users')->with('status', 'User deleted successfully! Order history has been preserved.');
    }
}
