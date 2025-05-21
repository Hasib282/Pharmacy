<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment_Method;
use Illuminate\Support\Facades\File;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/payment_method.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Payment_Method::on('mysql')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
