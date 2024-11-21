<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission_Main_Head;
use Illuminate\Support\Facades\File;

class PermissionMainHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/permission_mainheads.json");
        $permission_mainheads = collect(json_decode($json));

        $permission_mainheads->each(function($mainhead){
            Permission_Main_Head::create([
                "name"=>$mainhead->name,
            ]);
        });
    }
}
