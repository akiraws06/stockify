<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LaporanStockController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserActivityController;
use App\Models\Product;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use App\Models\Supplier;

Route::get('/', function () {
    return view('sign-in', ['title' => 'Login']);
})->name('index');


//Login
Route::get('/sign-in', [AuthController::class, 'login'])->name('login.tampil');
Route::post('/sign-in/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard
Route::get('/dashboard', [DashboardController::class, 'tampil'])->name('dashboard.tampil');

//Route Setting Profile
Route::get('/user/profile', [ProfileController::class, 'tampil'])->name('profile.tampil');
Route::post('/user/profile/update{id}', [ProfileController::class, 'update'])->name('profile.update');



//Route User
Route::middleware('auth')->group(function () {
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/user', [UserController::class, 'tampil'])->name('user.tampil');
        Route::get('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
        Route::post('/user/submit', [UserController::class, 'submit'])->name('user.submit');
        Route::get('user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/update{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('user/delete{id}', [UserController::class, 'delete'])->name('user.delete');
    });

// Route Product
Route::middleware(['role:Admin,Manager Gudang'])->group(function () {
    Route::get('/product', [ProductController::class, 'tampil'])->name('product.tampil');
    Route::get('/product/search', [ProductController::class, 'search    '])->name('product.search');
});
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/product/tambah', [ProductController::class, 'tambah'])->name('product.tambah');
    Route::post('/product/submit', [ProductController::class, 'submit'])->name('product.submit');
    Route::get('product/edit{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::post('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('/product/import', [ProductController::class, 'import'])->name('product.import');
    Route::get('/product/export/excel', [ProductController::class, 'export'])->name('product.export');
    Route::get('/product/download-template', function () {
        return response()->download(public_path('templates/products_template.xlsx'));
    })->name('product.downloadTemplate');

});

// Detail Product
Route::middleware(['role:Admin,Manager Gudang'])->group(function () {
    Route::get('/product/detail/{id}', [ProductController::class, 'showDetail'])->name('detail.tampil');
});
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/product/detail/tambah', [ProductController::class, 'addAtribute'])->name('detail.tambah');
    Route::post('/product/detail/submit', [ProductController::class, 'submitAtribute'])->name('detail.submit');
});
// Route Supplier
Route::middleware(['role:Admin,Manager Gudang'])->group(function () {
    Route::get('/supplier', [SupplierController::class, 'tampil'])->name('supplier.tampil');
});
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/supplier/tambah', [SupplierController::class, 'tambah'])->name('supplier.tambah');
    Route::post('/supplier/submit', [SupplierController::class, 'submit'])->name('supplier.submit');
    Route::get('supplier/edit{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('supplier/update{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('supplier/delete{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
});
// Route of Category
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/product/category', [CategoryController::class, 'tampil'])->name('product.category.tampil');
    Route::post('/product/category/submit', [CategoryController::class, 'submit'])->name('product.category.submit');
    Route::get('product/category/edit{id}', [CategoryController::class, 'edit'])->name('product.category.edit');
    Route::post('product/category/update{id}', [CategoryController::class, 'update'])->name('product.category.update');
    Route::post('product/category/delete{id}', [CategoryController::class, 'delete'])->name('product.category.delete');
});

// Route stock transaction
    Route::get('/stock/transaction/{type}', [TransactionController::class, 'tampil'])->name('stock.transaction.tampil');
    Route::middleware(['role:Manager Gudang'])->group(function () {
    Route::get('/stock/transaction/tambah', [TransactionController::class, 'tambah'])->name('stock.transaction.tambah');
    Route::post('/stock/transaction/submit/{type}', [TransactionController::class, 'submit'])->name('stock.transaction.submit');
    Route::post('/stock/transaction/delete/{type}', [TransactionController::class, 'delete'])->name('stock.transaction.delete');
});
Route::middleware(['role:Staff Gudang'])->group(function () {
Route::post('/stock/transaction/update-status/{id}', [TransactionController::class, 'updateStatus'])->name('update.status');
});
// Route Laporan
Route::middleware(['role:Manager Gudang,Admin'])->group(function () {
    Route::get('/laporan/transaction/{type}', [LaporanController::class, 'tampil'])->name('laporan.transaction.tampil');
    // Route Export Laporan
    Route::get('/laporan/transaction/export/excel/{type}', [LaporanController::class, 'exportToExcel'])->name('laporan.transaction.export.excel');
    Route::get('/laporan/transaction/export/pdf/{type}', [LaporanController::class, 'exportToPDF'])->name('laporan.transaction.export.pdf');
    // Route Stock Opname
    Route::get('/stock/opname', [StockController::class, 'tampil'])->name('stock.opname.tampil');
    // Route Laporan Stock
    Route::get('/laporan/stock', [LaporanStockController::class, 'tampil'])->name('laporan.stock.tampil');
    Route::get('/laporan/stock/export/pdf', [LaporanStockController::class, 'exportPdf'])->name('laporan.stock.export.pdf');
    Route::get('/laporan/stock/export/excel', [LaporanStockController::class, 'exportExcel'])->name('laporan.stock.export.excel');
});
});

// Route Setting
Route::middleware(['auth', 'role:Admin'])->group(function(){
Route::get('/setting', [SettingController::class, 'tampil'])->name('setting.tampil');
Route::get('/setting/tambah', [SettingController::class, 'tambah'])->name('setting.tambah');
Route::post('/setting/submit', [SettingController::class, 'submit'])->name('setting.submit');
Route::get('setting/edit{id}', [SettingController::class, 'edit'])->name('setting.edit');
Route::post('setting/update{id}', [SettingController::class, 'update'])->name('setting.update');

//Route User Activity
Route::get('/laporan/activity', [UserActivityController::class, 'tampil'])->name('laporan.activity');
Route::get('/laporan/activity/export/pdf', [UserActivityController::class, 'exportPdf'])->name('export.pdf');
Route::get('/laporan/activity/export/excel', [UserActivityController::class, 'exportExcel'])->name('export.excel');

});
