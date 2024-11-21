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
        $clients = collect(json_decode($json));

        $clients->each(function($client){
            User_Info::create([
                "user_id" => $client->user_id,
                "user_name" => $client->user_name,
                "user_email" => $client->user_email,
                "user_phone" => $client->user_phone,
                "gender" => "Male",
                "loc_id" => $client->loc_id,
                "address" => $client->address,
                "user_role" => 4,
                "tran_user_type" => $client->tran_user_type,
            ]);
        });
    }
}
