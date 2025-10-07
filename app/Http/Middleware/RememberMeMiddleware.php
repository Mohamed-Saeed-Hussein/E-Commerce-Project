<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RememberMeMiddleware
{
    /**
     * Handle an incoming request with enhanced remember me security.
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
            
            if ($rememberToken && strlen($rememberToken) === 60) {
                // Use secure token comparison to prevent timing attacks
                $user = User::where('remember_token', $rememberToken)->first();
                
                if ($user && hash_equals($user->remember_token, $rememberToken)) {
                    // Verify token hasn't expired (30 days)
                    $tokenCreatedAt = $user->updated_at;
                    if ($tokenCreatedAt && $tokenCreatedAt->diffInDays(now()) <= 30) {
                        // Log the user in automatically
                        $request->session()->put('auth.user_id', $user->id);
                        $request->session()->put('auth.email', $user->email);
                        $request->session()->put('auth.name', $user->name);
                        $request->session()->put('auth.role', $user->role);
                        $request->session()->put('auth.remember', true);
                        $request->session()->put('auth.last_activity', time());
                        
                        // Log automatic login for security
                        \Log::info('Remember me login', [
                            'user_id' => $user->id,
                            'ip' => $request->ip(),
                            'user_agent' => $request->userAgent(),
                            'timestamp' => now()
                        ]);
                    } else {
                        // Token expired, clear it
                        $user->clearRememberToken();
                    }
                }
            }
        }

        return $next($request);
    }
}
