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
        $banks = collect(json_decode($json));

        $banks->each(function($bank){
            Bank::create([
                "user_id" => $bank->user_id,
                "name" => $bank->name,
                "email" => $bank->email,
                "phone" => $bank->phone,
                "loc_id" => $bank->loc_id,
                "address" => $bank->address,
            ]);
        });
    }
}
