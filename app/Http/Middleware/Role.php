<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Memeriksa apakah pengguna terautentikasi
        if (!Auth::check()) {
            return redirect('404');
        }

        // Mendapatkan role_id pengguna
        $userRoleId = Auth::user()->role_id;

        // Mendapatkan nama peran dari tabel roles
        $userRole = \App\Models\Role::find($userRoleId);

        // Memeriksa apakah peran pengguna ditemukan
        if (!$userRole) {
            return redirect('404');
        }

        // Memeriksa apakah nama peran pengguna ada dalam daftar peran yang diizinkan
        if (!in_array($userRole->name, $roles)) {
            return redirect('404');
        }

        return $next($request);
    }
}
