<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockOpname;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Tentukan gambar default jika kosong
        $imagePath = $row['image'] ?? 'images/product/product.png'; // Path default jika tidak ada gambar

        // Simpan produk
        $product = Product::create([
            'name' => $row['name'],
            'sku' => $row['sku'],
            'description' => $row['description'],
            'purchase_price' => $row['purchase_price'],
            'selling_price' => $row['selling_price'],
            'image' => $this->handleImageUpload($row['image'] ?? null), // Proses gambar jika ada
            'category_id' => $row['category_id'],
            'supplier_id' => $row['supplier_id'],
            'stock' => $row['stock'],
            'stock_min' => $row['stock_min'],
        ]);

        // Buat entri StockOpname setelah produk dibuat
        StockOpname::create([
            'product_id' => $product->id,
            'category_id' => $product->category_id,
            'masuk' => 0, // Atur sesuai kebutuhan
            'keluar' => 0, // Atur sesuai kebutuhan
            'stock_akhir' => $product->stock, // Atur sesuai kebutuhan
            'tanggal' => now(), // Atur tanggal sesuai kebutuhan
        ]);
    }

    /**
     * Menangani unggahan gambar dan menyimpan file.
     */
    protected function handleImageUpload($image = null)
    {
        if ($image) {
            // Jika ada gambar, simpan gambar ke direktori yang sesuai
            $imagePath = 'images/product/' . uniqid() . '.' . pathinfo($image, PATHINFO_EXTENSION);
            Storage::put($imagePath, file_get_contents($image));
            return $imagePath;
        }

        // Jika tidak ada gambar, kembalikan gambar default
        return 'images/product/product.png';
    }
}
