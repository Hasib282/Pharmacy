<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item_Unit;
use Illuminate\Support\Facades\File;

class ItemUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/item_unit.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Item_Unit::on('mysql_second')->create([
                "unit_name"=>$item->unit_name,
                "type_id"=>$item->type_id,
            ]);
        });
    }
}
