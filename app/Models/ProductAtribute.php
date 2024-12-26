<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAtribute extends Model
{
    protected $table = 'productsAtribute';
    protected $fillable = [
        'product_id',
        'name',
        'value'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

//relasi


