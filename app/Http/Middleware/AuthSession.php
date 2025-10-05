<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSession
{
    /**
     * Ensure a user is authenticated via session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('auth.user_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}


