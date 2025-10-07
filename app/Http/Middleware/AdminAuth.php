<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminAuth
{
    /**
     * Handle an incoming request with enhanced admin authentication.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!$request->session()->has('auth.user_id')) {
            return redirect('/login')->with('error', 'Please log in to access admin panel.');
        }

        $userId = $request->session()->get('auth.user_id');
        $role = $request->session()->get('auth.role');

        // Verify user exists and has admin role
        $user = User::find($userId);
        if (!$user || $user->role !== 'admin') {
            $request->session()->invalidate();
            return redirect('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Double-check role from database (not just session)
        if ($user->role !== 'admin') {
            $request->session()->invalidate();
            return redirect('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Log admin access for security auditing
        \Log::info('Admin access', [
            'user_id' => $userId,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'timestamp' => now()
        ]);

        return $next($request);
    }
}
