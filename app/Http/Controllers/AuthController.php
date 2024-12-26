<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Pastikan untuk mengimpor model Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        return view('sign-in');
    }

    // Proses autentikasi pengguna
    public function submitLogin(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username_or_email' => 'required|string', // Mengganti 'login' dengan 'username_or_email'
            'password' => 'required|string',
        ]);

        // Mengambil data untuk autentikasi
        $data = $request->only('password');
        $login = $request->input('username_or_email'); // Mengambil input dari 'username_or_email'

        // Cek apakah login adalah email atau username
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $login; // Jika email
        } else {
            $data['username'] = $login; // Jika username
        }

        if (Auth::attempt($data)) {
            $request->session()->regenerate(); // Regenerasi session untuk keamanan
            return redirect()->route('dashboard.tampil'); // Redirect ke halaman pengguna setelah login berhasil
        } else {
            return redirect()->back()->with('gagal', 'Email/Username atau Password Anda Salah'); // Menampilkan pesan error
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.tampil'); // Redirect ke halaman utama setelah logout
    }
}
