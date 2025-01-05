<?php

namespace App\Http\Controllers;

use App\Models\Category;
Use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductAtribute;
use App\Models\StockOpname;
use App\Models\UserActivity;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel; 



class ProductController extends Controller
{
    function tampil(){
        $cat = Category::all();
        $supp = Supplier::all();
        $product = Product::with('category','supplier')->orderBy('created_at','desc');
        $prod = $product->paginate(20);
        
        // Tambahkan debug untuk melihat data produk
        return view('product.tampil', compact('product','cat', 'supp','prod'));
    }
    
    public function tambah(){

        $cat = Category::all();
        $supp = Supplier::all();
        return view('product.tambah', compact('cat','supp'));
    }

    public function submit(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan menambahkan data product ', 
        ]);
        $validatedData = Validator::make($request->all(),[
            'category_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:product,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'stock_min' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/product', 'public');
        } else {
            $imagePath = 'images/product/product.png';
        }

       $product =  Product::create([
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->input('description'),
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'stock_min' => $request->stock_min,
            'image' => $imagePath,
        ]);
        StockOpname::create([
            'product_id' => $product->id,
            'category_id' => $product->category_id,
            'masuk' => 0, // Atur sesuai kebutuhan
            'keluar' => 0, // Atur sesuai kebutuhan
            'stock_akhir' => $product->stock, // Atur sesuai kebutuhan
            'tanggal' => now(), // Atur tanggal sesuai kebutuhan
        ]);

        return redirect()->route('product.tampil')->with('success', 'Product created successfully.'); 
    }

    function edit($id){
        $product = Product::find($id);
        $cat = Category::with('category')->findOrFail($id);
        $supp = Supplier::with('supplier')->findOrFail($id);
        return view('product.edit', compact('product', 'cat', 'supp'));
    }
    function update(Request $request, $id){
        $product = Product::find($id);
        $changes = []; // Array untuk menyimpan perubahan

        // Cek perubahan untuk setiap field dan tambahkan ke array changes jika ada perubahan
        if ($product->category_id != $request->category_id) {
            $changes['category'] = $request->category_id;
        }
        if ($product->supplier_id != $request->supplier_id) {
            $changes['supplier'] = $request->supplier_id;
        }
        if ($product->name != $request->name) {
            $changes['name'] = $request->name;
        }
        if ($product->sku != $request->sku) {
            $changes['sku'] = $request->sku;
        }
        if ($product->description != $request->description) {
            $changes['description'] = $request->description;
        }
        if ($product->purchase_price != $request->purchase_price) {
            $changes['purchase_price'] = $request->purchase_price;
        }
        if ($product->selling_price != $request->selling_price) {
            $changes['selling_price'] = $request->selling_price;
        }
        if ($product->stock != $request->stock) {
            $changes['stock'] = $request->stock;
        }
        if ($product->stock_min != $request->stock_min) {
            $changes['stock_min'] = $request->stock_min;
        }
    
        // Jika ada perubahan, catat aktivitas
        if (!empty($changes)) {
            $changeText = 'User telah mengubah ' . implode(', ', array_keys($changes)) . ' pada produk ' . strtolower($product->name);
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $changeText, 
            ]);
        }


        $product = Product::find($id);
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->stock = $request->stock;
        $product->stock_min = $request->stock_min;
        // Upload image jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/product', 'public');
            $product->image = $imagePath; // Update image path
        }

        $product->save(); // Simpan perubahan

        return redirect()->route('product.tampil'); 
    }

    function delete($id){
        $product = Product::find($id);
        $product -> delete();
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah menghapus data product '. $product->name,
        ]);
        return redirect()->route('product.tampil');
    }

    // Import Product
    public function import(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan import data product ', 
        ]);
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new ProductImport, $request->file('file'));

        return redirect()->route('product.tampil')->with('success', 'Products imported successfully.');
    }

    // Export Product
    public function export() {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan export pdf laporan product ', 
        ]);
        return Excel::download(new ProductExport, 'products.xlsx'); // Mengunduh file Excel
    }

    // Search Product
    public function search(){
        $query = request('search'); // Ambil query pencarian dari request
        $product = Product::with('category','supplier')
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where('sku', 'like', "%{$query}%")
                                     ->orWhere('name', 'like', "%{$query}%");
            })
            ->get();
        $cat = Category::all();
        $supp = Supplier::all();
        return view('product.tampil', compact('product','cat', 'supp'));
    }

    // Detail Product

    public function showDetail($id){
        $product = Product::find($id);
        $atribute = ProductAtribute::where('product_id', $id)->with('product')->get();
        return view('product.detail.tampil', compact('product', 'atribute'));
    }
    public function addAtribute(){

        $product = Product::all();
        return view('product.detail.tambah', compact('product'));
    }
    public function submitAtribute(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);
    
        // Find the product to log activity
        $product = Product::findOrFail($request->product_id);
    
        // Log user activity
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan menambahkan detail product: ' . $product->name,
        ]);
    
        // Create the product attribute
        ProductAtribute::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'value' => $request->value,
        ]);
    
        // Redirect with success message
        return redirect()->route('detail.tampil', ['id' => $request->product_id])
                         ->with('success', 'Atribute created successfully.');
    }
    
}
