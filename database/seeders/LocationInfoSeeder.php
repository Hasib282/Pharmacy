<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location_Info;
use Illuminate\Support\Facades\File;

class LocationInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/location_info.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Location_Info::on('mysql')->create([
                "division" => $item->division,
                "district" => $item->district,
                "upazila" => $item->upazila,
            ]);
        });
    }
}
