<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission_Route;
use Illuminate\Support\Facades\File;

class RoutePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/route_permission.json");
        $route_permissions = collect(json_decode($json));

        $route_permissions->each(function($route_permission){
            Permission_Route::create([
                "permission_id"=>$route_permission->permission_id,
                "route_name"=>$route_permission->route_name,
            ]);
        });
    }
}
