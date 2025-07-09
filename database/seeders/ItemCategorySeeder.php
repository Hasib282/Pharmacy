<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item_Category;
use Illuminate\Support\Facades\File;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/item_category.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Item_Category::on('mysql_second')->create([
                "category_name"=>$item->category_name,
                "type_id"=>$item->type_id,
            ]);
        });
    }
}
