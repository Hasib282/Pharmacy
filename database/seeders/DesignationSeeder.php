<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;
use Illuminate\Support\Facades\File;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/designation.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Designation::on('mysql_second')->create([
                "designation"=>$item->designation,
                "dept_id"=>$item->dept_id,
            ]);
        });
    }
}
