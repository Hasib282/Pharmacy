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
        $manufacturers = collect(json_decode($json));

        $manufacturers->each(function($manufacturer){
            Item_Manufacturer::create([
                "manufacturer_name"=>$manufacturer->manufacturer_name,
                "type_id"=>$manufacturer->type_id,
            ]);
        });
    }
}
