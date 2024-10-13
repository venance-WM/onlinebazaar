<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer
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
        // Check if the user is logged in and has a role of 2
        if (Auth::check() && Auth::user()->role === 3) {
            return $next($request);
        }
        
 

        // If the user is not logged in or does not have the role of 3, redirect to login
        return redirect()->route('login')->withErrors(['unauthenticated' => 'Login first to continue...']);
    }
}
