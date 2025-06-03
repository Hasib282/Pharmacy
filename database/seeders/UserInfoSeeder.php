<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Login_User;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 'SA000000001',
                'user_name' => 'Hasibur Rahaman',
                'user_email' => 'hasiburrahman81098@gmail.com',
                'user_phone' => '01314353560',
                'user_role' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000002',
                'user_name' => 'Shafiuzzaman Thakur',
                'user_email' => 'shafiuzzamanthakur@gmail.com',
                'user_phone' => '01713867116',
                'user_type' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000003',
                'user_name' => 'Samin Rahman',
                'user_email' => 'samin1105009@gmail.com',
                'user_phone' => '01858162015',
                'user_type' => 1,
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000004',
                'user_name' => 'Md. Assaduzzaman',
                'user_email' => 'azshifat07@gmail.com',
                'user_phone' => '01828908967',
                'user_type' => 1,
                'password' => Hash::make('12345')
            ],
        ];

        Login_User::on('mysql')->insert($data);
    }
}
