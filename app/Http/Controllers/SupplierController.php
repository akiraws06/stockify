<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SupplierController extends Controller
{
    public function tampil()
    {
        $supplier = Supplier::paginate(20);
        return view('supplier.tampil', compact('supplier'));
    }

    public function tambah()
    {
        return view('supplier.tampil');
    }

    public function submit(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan menambahkan data supplier ', 
        ]);
        
        $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable|unique:suppliers,phone,required',
            'email' => 'nullable|email|unique:suppliers,email,required'
        ]);

        Supplier::create($request->all());
        return redirect()->route('supplier.tampil')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $changes = [];

        // Cek perubahan untuk setiap field dan tambahkan ke array changes jika ada perubahan
        if ($supplier->name != $request->name) {
            $changes['nama'] = $request->name;
        }
        if ($supplier->address != $request->address) {
            $changes['alamat'] = $request->address;
        }
        if ($supplier->phone != $request->phone) {
            $changes['telepon'] = $request->phone;
        }
        if ($supplier->email != $request->email) {
            $changes['email'] = $request->email;
        }
        $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable|unique:suppliers,phone,' . $id,
            'email' => 'nullable|email|unique:suppliers,email,' . $id
        ]);
        if (!empty($changes)) {
            $changeText = 'Supplier telah mengubah ' . implode(', ', array_keys($changes)) . ' pada supplier ' . strtolower($supplier->name);
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $changeText, 
            ]);
        }

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('supplier.tampil')->with('success', 'Supplier berhasil diperbarui');
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah menghapus data supplier '. strtolower($supplier->name),
        ]);
        return redirect()->route('supplier.tampil')->with('success', 'Supplier berhasil dihapus');
    }
}
