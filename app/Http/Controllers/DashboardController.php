<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

use App\Models\StockOpname;
use Carbon\Carbon;

class DashboardController extends Controller
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
                'transactions.created_at',
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
            ->whereIn('transactions.type', ['Masuk', 'Keluar']) // Pastikan untuk mengambil semua tipe yang relevan
            ->orderBy('transactions.product_id') // Urutkan berdasarkan product_id
            ->orderBy('transactions.created_at'); // Urutkan berdasarkan created_at untuk menghitung stock secara urut

        // Tambahkan filter berdasarkan tanggal
        if ($request->has('start-date') && $request->has('end-date')) {
            $transactions->whereBetween('transactions.updated_at', [$request->input('start-date'), $request->input('end-date')]);
        }

        // Tambahkan filter berdasarkan kategori
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $transactions->where('products.category_id', $request->input('category_id'));
        }
        $allTransactions = $transactions->get();
        $transactions = $transactions->paginate(10);
         // Ambil data setelah filter diterapkan

        // Ambil data produk dan user jika diperlukan untuk tampilan
        $us = User::all();
        $prod = Product::all();
        $category = Category::all();
        $stockOpname = StockOpname::paginate(10);
        
        $todayTransactions = $allTransactions->filter(function ($allTransactions) {
            return \Carbon\Carbon::parse($allTransactions->created_at)->isToday();
        });
        


        
    
        // Return ke view
    return view('dashboard.tampil', compact('transactions', 'prod', 'us', 'type', 'status', 'category', 'stockOpname','allTransactions','todayTransactions'));

        }
}



