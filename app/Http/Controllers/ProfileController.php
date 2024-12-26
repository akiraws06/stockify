<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function tampil()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Memastikan pengguna yang sedang masuk adalah pemilik profil
        if (auth()->user()->id !== $user->id) {
            return redirect()->route('profile.tampil')->with('error', 'Anda tidak memiliki izin untuk mengubah profil ini');
        }

        // Menambahkan validasi
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'username' => 'nullable|string|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Memperbarui data pengguna
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email')){
            $user->email = $request->email;
        }
        if($request->has('username')){
            $user->username = $request->username;
        }
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        if($request->hasFile('image')){
            $path = $request->file('image')->store('images/profile','public');
            $user->image = basename($path);
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('profile.tampil')->with('success', 'Profile berhasil diubah');
    }
}
