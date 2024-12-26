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
        // Menggunakan array untuk menyimpan data pengguna
        $users = [
            [
                "name" => "Admin",
                "username" => "admin",
                "email" => "admin@coba.com",
                "role_id" => 1,
                "password" => bcrypt('123456')
            ],
            [
                "name" => "Manager Gudang",
                "username" => "manager",
                "email" => "manager@coba.com",
                "role_id" => 2,
                "password" => bcrypt('123456')
            ],
            [
                "name" => "Staff Gudang",
                "username" => "staff",
                "email" => "staff@coba.com",
                "role_id" => 3,
                "password" => bcrypt('123456')
            ]
        ];

        // Loop untuk membuat pengguna
        foreach ($users as $user) {
            User::create($user);
        }
    }
}