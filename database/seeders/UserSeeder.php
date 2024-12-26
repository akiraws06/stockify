<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        User::create([
            "name" => "Admin",
            "username" => "admin",
            "role_id" => 1,
            "password" => bcrypt('123456')
        ]);
        User::create([
            "name" => "Manager Gudang",
            "username" => "manager",
            "role_id" => 2,
            "password" => bcrypt('123456')
        ]);
        User::create([
            "name" => "Staff Gudang",
            "username" => "staff",
            "role_id" => 3,
            "password" => bcrypt('123456')
        ]);
    }
}
