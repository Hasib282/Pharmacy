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
        $data = collect(json_decode($json));

        $data->each(function($item){
            Permission_Main_Head::on('mysql')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
