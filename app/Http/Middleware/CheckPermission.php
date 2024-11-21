<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();
        if(auth()->user()->hasPermissionToRoute($routeName)){
            return $next($request);
        }
        else{
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'notice' => 'You don\'t have permission to access this route.'
                ], 403);
            }
            // return $next($request);
            return back()->with('message', 'You don\'t have permisson to this route.')->with('status', 403);
        }
    }
}
