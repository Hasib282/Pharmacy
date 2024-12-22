<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;
use Illuminate\Support\Facades\File;

class BankInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/bank_info.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Bank::on('mysql')->create([
                "user_id" => $item->user_id,
                "name" => $item->name,
                "email" => $item->email,
                "phone" => $item->phone,
                "loc_id" => $item->loc_id,
                "address" => $item->address,
            ]);
        });
    }
}
