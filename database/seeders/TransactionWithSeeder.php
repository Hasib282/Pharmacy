<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction_With;
use Illuminate\Support\Facades\File;

class TransactionWithSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/tran_with.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Transaction_With::on('mysql_second')->create([
                "tran_with_name"=>$item->tran_with_name,
                "user_role"=>$item->user_role,
                "tran_type"=>$item->tran_type,
                "tran_method"=>$item->tran_method,
            ]);
        });
    }
}
