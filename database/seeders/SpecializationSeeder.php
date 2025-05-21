<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialization;
use Illuminate\Support\Facades\File;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/specialization.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Specialization::on('mysql_second')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
