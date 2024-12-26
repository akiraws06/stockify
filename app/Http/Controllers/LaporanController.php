<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use App\Exports\TransactionsExport;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;

class LaporanController extends Controller
{
    

    public function tampil(Request $request, $type)
    {
        $query = Transaction::with('product', 'user')->where('type', ucfirst($type));
        // Tambahkan filter berdasarkan tanggal
        if ($request->has('start-date') && $request->has('end-date')) {
            $query->whereBetween('date', [$request->input('start-date'), $request->input('end-date')]);
        }

        $transactions = $query->orderBy('created_at','desc')->paginate(20);
        
        return view('laporan.transaction.tampil', compact('transactions', 'type'));
    }

    public function exportToExcel($type)
    {
        $date = now()->format('Y-m-d');
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan export excel laporan transaksi ', 
        ]);
        return Excel::download(new TransactionsExport($type), 'transaksi_' . $type . '_' . $date . '.xlsx');
    }

    public function exportToPDF($type)
    {
        $date = now()->format('Y-m-d');
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan export pdf laporan transaksi ', 
        ]);
        $transactions = Transaction::with('product', 'user')
            ->where('type', ucfirst($type))
            ->get();

        $pdf = PDF::loadView('laporan.transaction_pdf', compact('transactions', 'type'));
        return $pdf->stream('transaksi_' . $type . '_' . $date . '.pdf');
    }
}
