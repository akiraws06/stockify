<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Path untuk direktori dan file default gambar produk
        $defaultPath = 'public/images/product';
        $defaultFile = $defaultPath . '/product.png';

        // Pastikan direktori untuk gambar produk ada
        if (!Storage::exists($defaultPath)) {
            Storage::makeDirectory($defaultPath);
        }

        // Pastikan file default tersedia
        if (!Storage::exists($defaultFile)) {
            Storage::put($defaultFile, file_get_contents(public_path('images/product/product.png'))); // Pastikan file sumber ada di 'public/images/product'
        }

        // Membuat tabel 'products'
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock');
            $table->integer('stock_min');
            $table->string('image')->default('images/product/product.png'); // Default image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
