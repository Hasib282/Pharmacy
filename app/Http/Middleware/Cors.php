<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Accept, Authorization, Content-Type')
                ->header('Access-Control-Allow-Credentials', 'true');
        } 
        catch (Exception $e) {
            // Log the exception
            Log::error('Error in middleware: ' . $e->getMessage());

            // Return a custom response (for example, a 500 error page or JSON response)
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
        
    }
}
