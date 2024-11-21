<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User_Info;
use Illuminate\Support\Facades\File;

class SupplierInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/supplier_info.json");
        $suppliers = collect(json_decode($json));

        $suppliers->each(function($supplier){
            User_Info::create([
                "user_id" => $supplier->user_id,
                "user_name" => $supplier->user_name,
                "user_email" => $supplier->user_email,
                "user_phone" => $supplier->user_phone,
                "gender" => "Male",
                "loc_id" => $supplier->loc_id,
                "address" => $supplier->address,
                "user_role" => 5,
                "tran_user_type" => $supplier->tran_user_type,
            ]);
        });
    }
}
