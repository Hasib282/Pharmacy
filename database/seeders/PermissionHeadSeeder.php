<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission_Head;
use Illuminate\Support\Facades\File;

class PermissionHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        $json = File::get("database/json/permission.json");
        $permissions = collect(json_decode($json));

        $permissions->each(function($permission){
            Permission_Head::create([
                "permission_mainhead" => $permission->permission_mainhead,
                "name"=>$permission->name,
            ]);
        });
    }
}