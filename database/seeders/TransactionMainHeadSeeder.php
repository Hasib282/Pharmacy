<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction_Main_Head;
use Illuminate\Support\Facades\File;

class TransactionMainHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/tran_main_head.json");
        $types = collect(json_decode($json));

        $types->each(function($type){
            Transaction_Main_Head::create([
                "type_name"=>$type->type_name,
            ]);
        });
    }
}
