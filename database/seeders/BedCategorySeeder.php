<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bed_Category;
use Illuminate\Support\Facades\File;

class BedCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/bed_category.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Bed_Category::on('mysql_second')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
