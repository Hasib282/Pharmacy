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
        $data = collect(json_decode($json));

        $data->each(function($item){
            Permission_Route::on('mysql')->create([
                "permission_id"=>$item->permission_id,
                "route_name"=>$item->route_name,
            ]);
        });
    }
}
