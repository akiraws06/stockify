<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Make sure to include Role if you want to manage roles
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{   
    // Display the user list
    public function tampil()
    {
        $users = User::with('role')->get(); // Mengambil semua pengguna beserta role mereka
        $roles = Role::all(); // Mengambil semua role dari database
        return view('user.tampil', compact('users', 'roles')); // Mengirimkan data pengguna dan role ke view
    }

    // Show form to add a new user
    public function tambah()
    {
        $roles = Role::all(); // Mengambil semua role dari database
        return view('user.tampil', compact('roles')); // Mengirim data role ke view
    }
    // Menyimpan data pendaftaran
    public function submit(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah menambahkan data pengguna baru',
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Validasi email
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6|',
            'role_id' => 'required|exists:roles,id',
        ]);
        
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // Pastikan email ada
            'username' => $request->username,
            'password' => Hash::make($request->password), 
            'role_id' => $request->role_id,
        ]);
        return redirect()->route('user.tampil')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id); 
        $roles = Role::all(); 
        return view('user.edit', compact('user', 'roles')); // Mengirimkan pengguna dan role ke view
    }

    // Menyimpan perubahan pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Mengambil pengguna berdasarkan ID
        $changes = [];

        // Cek perubahan untuk setiap field dan tambahkan ke array changes jika ada perubahan
        if ($user->role_id != $request->role_id) {
            $changes['role'] = $request->role_id;
        } else {
            unset($changes['role']);
        }
        if ($user->name != $request->name) {
            $changes['nama'] = $request->name;
        }
        if ($user->username != $request->username) {
            $changes['username'] = $request->username;
        }
        if ($user->email != $request->email) {
            $changes['email'] = $request->email;
        }
       

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Validasi email, kecuali untuk pengguna ini
            'username' => 'required|string|unique:users,username,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6', // Password dapat kosong saat update
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->save(); // Simpan perubahan
        
        // Catat perubahan ke Activity
        if (!empty($changes)) {
            $changeText = 'User telah mengubah ' . implode(', ', array_keys($changes)) . ' pada pengguna ' . $user->name;
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $changeText, 
            ]);
        }
        return redirect()->route('user.tampil')->with('success', 'Pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function delete($id)
    {
        $user = User::findOrFail($id); // Mengambil pengguna berdasarkan ID
        $user->delete(); // Menghapus pengguna

        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah menghapus data pengguna '. $user->name,
        ]);
        return redirect()->route('user.tampil')->with('success', 'Pengguna berhasil dihapus!');
    }
    
}