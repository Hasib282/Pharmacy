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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->header('Origin');

        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return response()->json(['status' => 'success'], 200)
                ->header('Access-Control-Allow-Origin', $origin ?? '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'X-CSRF-Token, Accept, Authorization, Content-Type')
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        // Handle actual requests
        return $next($request)
            ->header('Access-Control-Allow-Origin', $origin ?? '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-CSRF-Token, Accept, Authorization, Content-Type')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}
