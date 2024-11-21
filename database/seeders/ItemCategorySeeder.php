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
        $categories = collect(json_decode($json));

        $categories->each(function($category){
            Item_Category::create([
                "category_name"=>$category->category_name,
                "type_id"=>$category->type_id,
            ]);
        });
    }
}
