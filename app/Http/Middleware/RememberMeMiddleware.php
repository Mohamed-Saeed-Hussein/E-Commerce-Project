<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RememberMeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only check remember me if user is not already logged in
        if (!$request->session()->has('auth.user_id')) {
            $rememberToken = $request->cookie('remember_me');
            
            if ($rememberToken) {
                $user = User::where('remember_token', $rememberToken)->first();
                
                if ($user) {
                    // Log the user in automatically
                    $request->session()->put('auth.user_id', $user->id);
                    $request->session()->put('auth.email', $user->email);
                    $request->session()->put('auth.name', $user->name);
                    $request->session()->put('auth.role', $user->role);
                    $request->session()->put('auth.remember', true);
                }
            }
        }

        return $next($request);
    }
}
