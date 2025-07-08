<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminSuperAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->user_role == 1 || Auth::user()->user_role == 2) {
            return $next($request);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'You don\'t have permisson to this route.',
            ], 403);
        }
    }
}
