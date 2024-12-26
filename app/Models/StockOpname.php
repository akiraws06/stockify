<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = 'stockOpname';
    protected $fillable = [
        'category_id',
        'product_id',
        'masuk',
        'keluar',
        'stock_akhir',
        'tanggal'   
    ];

    // Relasi
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
