<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\File;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/role.json");
        $roles = collect(json_decode($json));

        $roles->each(function($role){
            Role::create([
                "name"=>$role->name,
            ]);
        });
    }
}
