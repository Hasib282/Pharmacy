<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'user_id' => 'SA000000001',
                'user_name' => 'Hasibur Rahaman',
                'user_email' => 'hasiburrahman81098@gmail.com',
                'user_phone' => '01314353560',
                'gender' => 'Male',
                'loc_id' => 1,
                'user_role' => 1,
                'dob' => '1990-01-01',
                'nid' => '123456789',
                'password' => Hash::make('12345')
            ],
            [
                'user_id' => 'SA000000002',
                'user_name' => 'Shafiuzzaman Thakur',
                'user_email' => 'shafiuzzamanthakur@gmail.com',
                'user_phone' => '01713867116',
                'gender' => 'Male',
                'loc_id' => 2,
                'user_type' => 1,
                'dob' => '1992-02-02',
                'nid' => '987654321',
                'password' => Hash::make('12345')
            ],
        ];

        DB::table('user__infos')->insert($users);
    }
}
