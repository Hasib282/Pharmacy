<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction_Groupe;
use Illuminate\Support\Facades\File;

class TransactionGroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/tran_groupe.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Transaction_Groupe::on('mysql_second')->create([
                "tran_groupe_name"=>$item->tran_groupe_name,
                "tran_groupe_type"=>$item->tran_groupe_type,
                "tran_method"=>$item->tran_method,
            ]);
        });
    }
}
