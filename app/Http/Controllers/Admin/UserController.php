<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function update(Request $request, $id)
    {
        return back()->withErrors(['name' => 'User name and email editing is disabled. Only role changes are allowed.']);
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Set user_id to null for all orders to preserve transaction data
        \App\Models\Order::where('user_id', $user->id)->update(['user_id' => null]);
        
        $user->delete();
        
        return redirect('/admin/users')->with('status', 'User deleted successfully! Order history has been preserved.');
    }
}
