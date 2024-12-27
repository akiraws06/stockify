<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import
use App\Models\Product; // Pastikan model Product di-import
use App\Models\StockOpname; // Pastikan model StockOpname di-import

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
     
        $product = [
            [
                'name' => 'Meja',
                'sku' => 'MJ123',
                'description' => 'Dari kayu.',
                'purchase_price' => '50000',
                'selling_price' => '60000',
                'category_id' => '2',
                'supplier_id' => '2',
                'stock' => '0',
                'stock_min' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buku',
                'sku' => 'BK123',
                'description' => 'buat nulis.',
                'purchase_price' => '12000',
                'selling_price' => '15000',
                'category_id' => '3',
                'supplier_id' => '1',
                'stock' => '0',
                'stock_min' => '20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Earphone',
                'sku' => 'EP123',
                'description' => 'Alat untuk mendengarkan musik.',
                'purchase_price' => '75000',
                'selling_price' => '80000',
                'category_id' => '1',
                'supplier_id' => '3',
                'stock' => '0',
                'stock_min' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($product as $productData) {
            // Simpan data produk ke database
            $createdProduct = Product::create([
                'name' => $productData['name'],
                'sku' => $productData['sku'],
                'description' => $productData['description'],
                'purchase_price' => $productData['purchase_price'],
                'selling_price' => $productData['selling_price'],
                'category_id' => $productData['category_id'],
                'supplier_id' => $productData['supplier_id'],
                'stock' => $productData['stock'],
                'stock_min' => $productData['stock_min'],
            ]);

            // Simpan data stock opname
            StockOpname::create([
                'product_id' => $createdProduct->id,
                'category_id' => $createdProduct->category_id,
                'masuk' => 0, // Atur sesuai kebutuhan
                'keluar' => 0, // Atur sesuai kebutuhan
                'stock_akhir' => $createdProduct->stock, // Atur sesuai kebutuhan
                'tanggal' => now(), // Atur tanggal sesuai kebutuhan
            ]);
        }
    }
}