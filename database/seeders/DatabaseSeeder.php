<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this::call([
            
            TransactionMainHeadSeeder::class,
            DepartmentInfoSeeder::class,
            DesignationSeeder::class,
            LocationInfoSeeder::class,
            ItemUnitSeeder::class,
            ItemFormSeeder::class,
            ItemManufacturerSeeder::class,
            ItemCategorySeeder::class,
            
            
            StoreSeeder::class,
            RoleSeeder::class,
            PermissionMainHeadSeeder::class,
            PermissionHeadSeeder::class,
            RoutePermissionSeeder::class,

            
            TransactionWithSeeder::class,
            TransactionGroupeSeeder::class,
            TransactionHeadSeeder::class,

            
            UserInfoSeeder::class,
            ClientInfoSeeder::class,
            SupplierInfoSeeder::class,
            BankInfoSeeder::class,
            
        ]);
    }
}
