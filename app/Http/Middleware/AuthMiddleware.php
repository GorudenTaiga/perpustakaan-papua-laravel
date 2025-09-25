<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirect unauthenticated users
        }

        $user = Auth::user();

        foreach ($role as $roles) {
            if ($user->role === $roles) { // Assuming a hasRole method on your User model
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}