<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('desc')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock');
            $table->integer('stock_min');
            $table->string('image')->nullable()->default('product.png');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}; 