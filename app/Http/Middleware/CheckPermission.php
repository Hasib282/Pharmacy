<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->user_role == 1) {
            return $next($request);
        }

        $userPermissions = Cache::get("permission_ids_". Auth::user()->user_id);
        if(!$userPermissions){
            $user_data = Auth::user();
            $userPermissions = Cache::rememberForever("permission_ids_". Auth::user()->user_id, function () use ($user_data) {
                return $user_data->permissions->pluck('id')->unique()->toArray();
            });
        }

        $currentRoute = $request->route()->uri();
        $currentMethod = $request->method();

        // Check if the user has permission
        $permissionsMap = Cache::get("permissions_map");
        if(!$permissionsMap){
            $permissionsMap = Cache::rememberForever('permissions_map', function () {
                return config('permissions');
            });
        }
        
        foreach ($userPermissions as $permissionId) {
            if (isset($permissionsMap[$permissionId])) {
                foreach ($permissionsMap[$permissionId] as $route) {
                    if ($route['uri'] === $currentRoute && $route['method'] === $currentMethod) {
                        return $next($request); // Allowed
                    }
                }
            }
        }

        return response()->json([
            'status' => false,
            'notice' => 'You don\'t have permission to access this route.'
        ], 403);
    }
}
