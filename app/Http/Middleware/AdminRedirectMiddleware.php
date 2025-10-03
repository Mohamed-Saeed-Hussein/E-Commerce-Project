<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRedirectMiddleware
{
    /**
     * If the logged-in user is an admin, prevent access to non-admin pages
     * by redirecting to the admin dashboard.
     */
    public function handle(Request $request, Closure $next)
    {
        $isLoggedIn = $request->session()->has('auth.user_id');
        $role = $request->session()->get('auth.role');

        // Only apply on web routes, skip for admin prefix and auth/logout endpoints
        $path = trim($request->path(), '/');

        // Block any non-admin access to admin pages by showing error page
        if (str_starts_with($path, 'admin')) {
            if (!($isLoggedIn && $role === 'admin')) {
                abort(404);
            }
        }

        if ($isLoggedIn && $role === 'admin') {
            $isAdminPath = str_starts_with($path, 'admin');
            $isProfilePath = $path === 'profile' || $path === 'profile/update' || $path === 'profile/delete';
            if (!$isAdminPath && !$isProfilePath) {
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}


