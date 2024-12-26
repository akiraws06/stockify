<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Models\StockOpname;
use App\Models\Stock;
use App\Exports\StockExport;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\DB;
use PDF;
use Excel;



class LaporanStockController extends Controller
{


    function tampil(Request $request){
        $status = ['Pending', 'Diterima', 'Ditolak', 'Dikeluarkan'];
        $type = ['Masuk', 'Keluar'];
        // Ambil transaksi menggunakan SUM OVER untuk running total stock
        $transactions = DB::table('transactions')
            ->select(
                'transactions.id',
                'transactions.product_id',
                'transactions.type',
                'transactions.quantity',
                'transactions.status',
                'transactions.date',
                'transactions.notes',
                'transactions.updated_at',
                'products.name AS product_name', // Ambil nama produk dari tabel products
                'products.stock AS min_stock',
                'products.sku AS product_sku',
                'users.name AS user_name',
                'categories.name AS category_name',
                 // Ambil nama user dari tabel users
                DB::raw("
                    SUM(
                        CASE 
                            WHEN transactions.type = 'Masuk' && transactions.status = 'Diterima' THEN transactions.quantity
                            WHEN transactions.type = 'Keluar' && transactions.status = 'Dikeluarkan' THEN -transactions.quantity

                        END
                    ) OVER (PARTITION BY transactions.product_id ORDER BY transactions.created_at) AS stock_sementara
                ")
            )
            ->join('products', 'transactions.product_id', '=', 'products.id') // Gabungkan dengan tabel produk jika diperlukan
            ->join('users', 'transactions.user_id', '=', 'users.id') // Gabungkan dengan tabel user jika diperlukan
            ->join('categories', 'products.category_id', '=', 'categories.id') // Gabungkan dengan tabel user jika diperlukan
            ->whereIn('transactions.type', ['Masuk', 'Keluar']) // Pastikan untuk mengambil semua tipe yang relevan// Urutkan berdasarkan product_id
            ->orderBy('transactions.updated_at','desc')
            ->paginate(20); // Urutkan berdasarkan created_at untuk menghitung stock secara urut

        // Tambahkan filter berdasarkan tanggal
        if ($request->has('start-date') && $request->has('end-date')) {
            $transactions->whereBetween('transactions.updated_at', [$request->input('start-date'), $request->input('end-date')]);
            $transaction=Transaction::with('stockOpname')->orderBy('created_at','desc')->paginate(20);

        }

        // Tambahkan filter berdasarkan kategori
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $transactions->where('products.category_id', $request->input('category_id'));
            $transaction=Transaction::with('stockOpname')->orderBy('created_at','desc')->paginate(20);

        }

        // Ambil data produk dan user jika diperlukan untuk tampilan
        $us = User::all();
        $prod = Product::all();
        $category = Category::all();
        $transaction=Transaction::with('stockOpname')->orderBy('created_at','desc')->paginate(20);
    
    return view('laporan.stock.tampil', compact('transactions', 'prod', 'us', 'type', 'status', 'category', 'transaction'));

        }

        function exportPdf(Request $request){
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => 'User telah melakukan export pdf laporan stock ', 
            ]);
            $date = date('Y-m-d');
            $transactions = $this->getFilteredTransactions($request); // Ambil transaksi yang difilter
            $pdf = PDF::loadView('laporan.stock.stock_pdf', compact('transactions'));
            return $pdf->stream('laporan_transaksi_'.$date.'.pdf');
        }

        function exportExcel(Request $request){
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => 'User telah melakukan export excel laporan stock ', 
            ]);
            $date = date('Y-m-d');
            $transactions = $this->getFilteredTransactions($request); // Ambil transaksi yang difilter
            return Excel::download(new StockExport($transactions), 'laporan_transaksi_'.$date.'.xlsx');
        }

        private function getFilteredTransactions(Request $request) {
            $status = ['Pending', 'Diterima', 'Ditolak', 'Dikeluarkan'];
            $type = ['Masuk', 'Keluar'];
            $transactions = DB::table('transactions')
                ->select(
                    'transactions.id',
                    'transactions.product_id',
                    'transactions.type',
                    'transactions.quantity',
                    'transactions.status',
                    'transactions.date',
                    'transactions.notes',
                    'transactions.updated_at',
                    'products.name AS product_name',
                    'products.stock AS min_stock',
                    'products.sku AS product_sku',
                    'users.name AS user_name',
                    'categories.name AS category_name',
                    DB::raw("
                        SUM(
                            CASE 
                                WHEN transactions.type = 'Masuk' && transactions.status = 'Diterima' THEN transactions.quantity
                                WHEN transactions.type = 'Keluar' && transactions.status = 'Dikeluarkan' THEN -transactions.quantity
                            END
                        ) OVER (PARTITION BY transactions.product_id ORDER BY transactions.created_at) AS stock_sementara
                    ")
                )
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->join('users', 'transactions.user_id', '=', 'users.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereIn('transactions.type', ['Masuk', 'Keluar'])
                ->orderBy('transactions.product_id')
                ->orderBy('transactions.created_at');

            // Tambahkan filter berdasarkan tanggal
            if ($request->has('start-date') && $request->has('end-date')) {
                $transactions->whereBetween('transactions.updated_at', [$request->input('start-date'), $request->input('end-date')]);
            }

            // Tambahkan filter berdasarkan kategori
            if ($request->has('category_id') && $request->input('category_id') != '') {
                $transactions->where('products.category_id', $request->input('category_id'));
            }

            return $transactions->paginate(20); // Ambil data setelah filter diterapkan
        }       
}
    
