<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Floor;
use Illuminate\Support\Facades\File;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/floor.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Floor::on('mysql_second')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
