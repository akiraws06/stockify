<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productsAtribute', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Menambahkan kolom product_id
            $table->string('name')->comment('Misalnya: ukuran, warna, berat'); // Menambahkan kolom name dengan catatan
            $table->string('value'); // Menambahkan kolom value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsAtribute'); // Menghapus tabel jika ada
    }
};
