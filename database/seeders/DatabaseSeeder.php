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
        $this->call([
            RolesTableSeeder::class,
            UserSeeder::class,
            SuppliersTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            SettingSeeder::class,
            TransactionSeeder::class,


            // ... seeder lainnya
        ]);
    }
}
