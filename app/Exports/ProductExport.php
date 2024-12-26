<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with(['category:id,name', 'supplier:id,name'])
            ->get()
            ->map(function ($product) {
                return [
                    $product->id,
                    $product->sku,
                    $product->name,
                    $product->category->name,
                    $product->description,
                    $product->purchase_price,
                    $product->selling_price,
                    $product->image,
                    $product->supplier->name,
                    $product->stock,
                    $product->stock_min,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'SKU',
            'Product Name',
            'Category',
            'Description',
            'Purchase Price',
            'Selling Price',    
            'Image',
            'Supplier',
            'Stock Awal',
            'Stock Minimal',

        ]; // Menentukan judul kolom untuk file Excel
    }
}