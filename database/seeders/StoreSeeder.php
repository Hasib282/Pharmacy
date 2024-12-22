<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use Illuminate\Support\Facades\File;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/store.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Store::on('mysql_second')->create([
                "store_name"=>$item->store_name,
                "division"=>$item->division,
                "location_id"=>$item->location,
            ]);
        });
    }
}
