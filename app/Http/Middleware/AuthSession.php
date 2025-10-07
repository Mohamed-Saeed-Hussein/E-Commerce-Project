<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AuthSession
{
    /**
     * Ensure a user is authenticated via session with enhanced security checks.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user session exists
        if (!$request->session()->has('auth.user_id')) {
            return redirect('/login')->with('error', 'Please log in to access this page.');
        }

        $userId = $request->session()->get('auth.user_id');
        
        // Verify user still exists and is active
        $user = User::find($userId);
        if (!$user) {
            $request->session()->invalidate();
            return redirect('/login')->with('error', 'Your session has expired. Please log in again.');
        }

        // Regenerate session ID periodically for security
        if (!$request->session()->has('auth.last_activity') || 
            time() - $request->session()->get('auth.last_activity') > 1800) { // 30 minutes
            $request->session()->regenerate();
            $request->session()->put('auth.last_activity', time());
        }

        // Add user to request for easy access
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}


