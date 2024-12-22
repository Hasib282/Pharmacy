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
        $data = collect(json_decode($json));

        $data->each(function($item){
            Permission_Head::on('mysql')->create([
                "permission_mainhead" => $item->permission_mainhead,
                "name"=>$item->name,
            ]);
        });
    }
}