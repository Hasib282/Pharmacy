<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Company_Details;

class CompanyDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/company_details.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Company_Details::on('mysql')->create([
                "company_id"=>$item->id,
                "company_name"=>$item->name,
                "company_email"=>$item->email,
                "company_phone"=>$item->phone,
                "address"=>$item->address,
                "company_type"=>$item->type,
            ]);
        });
    }
}
