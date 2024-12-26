<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB; // Perbarui import ini


class TransactionController extends Controller
{
    public function tampil($type)
    {
        $status = ['Pending', 'Diterima', 'Ditolak', 'Dikeluarkan'];
        $transactions = Transaction::with('product','user')
        ->where('type', $type)
        ->orderBy('created_at', 'desc')
        ->paginate(20); 
        $us = User::all();
        $prod = Product::all();
        return view('stock.transaction.tampil', compact('transactions', 'prod', 'us','type', 'status')); 
    }

    function tambah(){
        return view('stock.transaction.tambah', compact('types', 'status'));
    }

            public function submit(Request $request, $type)
            {
                UserActivity::create([
                    'user_id' => Auth::id(),
                    'activity' => 'User telah melakukan tambah transaksi '.strtolower($type).' baru',
                ]);
                $request->validate([
                    'product_id' => 'required|exists:products,id',
                    'user_id' => 'required|exists:users,id',
                    'quantity' => 'required|integer',
                    'date' => 'required|date',
                    'notes' => 'nullable|string',
                    
                ]);
                

            Transaction::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'status' => 'Pending',
                'notes' => $request->notes,
                'type' => ucfirst($type),

            ]);



    return redirect()->route('stock.transaction.tampil', ['type'=> $type])->with('success', 'Transaction created successfully.');
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $request->status]);
        $transaction->save();
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan update status transaksi'.($transaction->type).' menjadi ' . $request->status, 
        ]);
    }
   
}
