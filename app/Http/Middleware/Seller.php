<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Seller
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
        if (Auth::check() && Auth::user()->role === 2) {
            return $next($request);
        }
 

        // If the user does not have the role of 2, redirect back
        return redirect()->back()->withErrors(['unauthorized' => 'You do not have access to this page.']);
    }
}
