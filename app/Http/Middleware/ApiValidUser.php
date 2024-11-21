<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ApiValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->bearerToken()) {
        //     // Fetch user data from the API
        //     $response = Http::withToken($request->bearerToken())
        //         ->get(config('services.api.url') . '/get/currentuser');

        //     if ($response->ok()) {
        //         // Pass the user data to all views
        //         view()->share('currentUser', $response->json());
        //     }
        // }
        // else{
            
        // }

        // return $next($request);












        if ($request->user()) {
            // Check if trying to access login route and already logged in
            if ($request->getRequestUri() == '/login' || $request->getRequestUri() == '/forgetpassword' || strpos($request->getRequestUri(), '/resetpassword') !== false) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are already logged in.',
                    'redirect' => '/dashboard',
                ], 401);
            }
            
            $user = $request->user()->load('permissions');
            $request->attributes->set('user', $user);
            view()->share('currentUser', $user);
            return $next($request);
        } 
        else {
            // Check if trying to access routes other than login when not logged in
            if ($request->getRequestUri() == '/login' || $request->getRequestUri() == '/forgetpassword' || strpos($request->getRequestUri(), '/resetpassword') !== false) {
                return $next($request);
            }

            return response()->json([
                'status' => false,
                'message' => 'You need to login first.',
                'redirect' => '/login',
            ], 401);
        }
    }
}
