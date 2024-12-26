<?php

namespace App\Exports;

use App\Models\StockOpname;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromCollection, WithHeadings, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                'SKU' => $transaction->product_sku,
                'Category' => $transaction->category_name,
                'Product' => $transaction->product_name,
                'Quantity' => $transaction->quantity,
                'Current Stock' => $transaction->stock_sementara,
                'Time' => \Carbon\Carbon::parse($transaction->updated_at)->format('H:i:s'),
                'Date' => \Carbon\Carbon::parse($transaction->updated_at)->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Category',
            'Product',
            'Quantity',
            'Current Stock',
            'Time',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}