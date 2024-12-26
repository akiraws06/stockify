<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $type;

    public function __construct($type)
    {
        $this->type = ucfirst($type);
    }

    public function collection()
    {
        return Transaction::with('product', 'user')
            ->where('type', $this->type)
            ->get()->map(function ($transaction) {
                return [
                    'Product' => $transaction->product->name,
                    'User' => $transaction->user->name,
                    'Type' => $transaction->type,
                    'Quantity' => $transaction->quantity,
                    'Date' => $transaction->date,
                    'Status' => $transaction->status,
                    'Notes' => $transaction->notes,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Product',
            'User',
            'Type',
            'Quantity',
            'Date',
            'Status',
            'Notes',
        ];
    }
}