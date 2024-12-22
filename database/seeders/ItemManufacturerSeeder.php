<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item_Manufacturer;
use Illuminate\Support\Facades\File;

class ItemManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/item_manufacturer.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Item_Manufacturer::on('mysql')->create([
                "manufacturer_name"=>$item->manufacturer_name,
                "type_id"=>$item->type_id,
            ]);
        });
    }
}
