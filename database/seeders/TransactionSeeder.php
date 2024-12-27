<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [
            [
                'product_id' => '1', 
                'user_id' => 2,
                'type' => 'Masuk',
                'quantity' => 20,
                'date' => now(),
                'status' => 'Pending',
                'notes' => null,
                
            ],
            [
                'product_id' => '1', 
                'user_id' => 2,
                'type' => 'Keluar',
                'quantity' => 5,
                'date' => now(),
                'status' => 'Pending',
                'notes' => null,
                
            ],
        ];
        
        foreach ($transactions as $transData){
            Transaction::create($transData);
        } 
    }
} 