<?php

namespace App\Http\Controllers\API\Backend\Admin_Setup\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

use App\Models\Permission_Head;
use App\Models\Permission_Route;
use App\Http\Middleware\ValidUser;

class RoutePermissionController extends Controller
{
    // Show All Route Permissions
    public function ShowAll(Request $req){
        $permissionroute = Permission_Head::on('mysql')->with('routes')->paginate(15);
        return response()->json([
            'status'=> true,
            'data' => $permissionroute,
        ], 200);
    } // End Method



    // Edit Route Permissions
    public function Edit(Request $req){
        $permission = Permission_Head::on('mysql')->where('id',$req->id)->first();
        $permissionroute = Permission_Route::on('mysql')->where('permission_id', $req->id)->pluck('route_name')->toArray();


        $routes = Route::getRoutes();

        // $middlewareGroupe = ValidUser::class;
        $middlewareGroupe = 'auth:sanctum';
        $routeDetails = [];

        foreach($routes as $route){
            $middlewares = $route->gatherMiddleware();
            if(in_array($middlewareGroupe, $middlewares)){
                $routeName = $route->getName();
                if($routeName !== 'dashboard' && $routeName !== 'logout'){
                    $routeDetails[] = [
                        'name' => $routeName,
                        'uri' => $route->uri(),
                    ];
                }
            }
        }

        return response()->json([
            'status'=> true,
            'permission'=>$permission,
            'permissionroute'=>$permissionroute,
            'routeDetails' => $routeDetails,
        ], 200);
    } // End Method



    // Update Route Permissions
    public function Update(Request $req){
        $permission = Permission_Head::on('mysql')->findOrFail($req->permission);

        $req->validate([
            'permission' => 'required|exists:mysql.permission__heads,id',
            'routes' => 'array',
            'routes.*' => 'string',
        ]);

        $existingRoutes = $permission->routes()->pluck('route_name')->toArray();

        $routesToAdd = array_diff($req->routes, $existingRoutes);

        $routesToRemove = array_diff($existingRoutes, $req->routes);

        foreach ($routesToAdd as $routeName) {
            Permission_Route::on('mysql')->create([
                'permission_id' => $permission->id,
                'route_name' => $routeName,
            ]);
        }

        Permission_Route::on('mysql')->where('permission_id', $permission->id)
            ->whereIn('route_name', $routesToRemove)
            ->delete();
        
        return response()->json([
            'status'=> true,
            'message' => 'Route Permissions Added Successfully'
        ], 200);  
    } // End Method



    // Search Route Permissions
    public function Search(Request $req){
        $permissionroute = Permission_Head::on('mysql')->where('name', 'like', '%'.$req->search.'%')
        ->with('routes')
        ->orderBy('name')
        ->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $permissionroute,
        ], 200);
    } // End Method
}
