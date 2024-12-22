<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User_Info;
use Illuminate\Support\Facades\File;

class ClientInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/client_info.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            User_Info::on('mysql_second')->create([
                "user_id" => $item->user_id,
                "user_name" => $item->user_name,
                "user_email" => $item->user_email,
                "user_phone" => $item->user_phone,
                "gender" => "Male",
                "loc_id" => $item->loc_id,
                "address" => $item->address,
                "user_role" => 4,
                "tran_user_type" => $item->tran_user_type,
            ]);
        });
    }
}
