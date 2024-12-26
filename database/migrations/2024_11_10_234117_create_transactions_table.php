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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Perbaikan nama tabel menjadi 'products'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['Masuk', 'Keluar']);
            $table->integer('quantity');
            $table->date('date');
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak', 'Dikeluarkan']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
