<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Check if trying to access login route and already logged in
            if ($request->getRequestUri() == '/login' || $request->getRequestUri() == '/forgotpassword' || strpos($request->getRequestUri(), '/resetpassword') !== false) {
                return back()->with('message', 'You are already logged in.');
            }
            return $next($request);
        } 
        else {
            // Check if trying to access routes other than login when not logged in
            if ($request->getRequestUri() == '/login' || $request->getRequestUri() == '/forgotpassword' || strpos($request->getRequestUri(), '/resetpassword') !== false) {
                return $next($request);
            }
            return redirect()->route('login')->with('message', 'You need to login first.');
        }
    }
}
