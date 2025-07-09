<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction_Head;
use Illuminate\Support\Facades\File;

class TransactionHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/tran_heads.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Transaction_Head::on('mysql_second')->create([
                "tran_head_name" => $item->tran_head_name,
                "groupe_id" => $item->groupe_id,
                "category_id" => $item->category_id,
                "manufacturer_id" => $item->manufacturer_id,
                "form_id" => $item->form_id,
                "unit_id" => $item->unit_id,
            ]);
        });
    }
}
