<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Company_Type;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/company_type.json");
        $data = collect(json_decode($json));

        $data->each(function($item){
            Company_Type::on('mysql')->create([
                "name"=>$item->name,
            ]);
        });
    }
}
