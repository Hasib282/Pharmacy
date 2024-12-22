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
        $data = collect(json_decode($json));

        $data->each(function($item){
            Transaction_Main_Head::on('mysql')->create([
                "type_name"=>$item->type_name,
            ]);
        });
    }
}
