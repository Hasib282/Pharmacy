<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\File;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/department.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Department::on('mysql_second')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
