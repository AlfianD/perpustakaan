<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login gabungan (Admin & Karyawan)
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses Login untuk Karyawan (Anggota)
     */
    /**
     * Proses Login untuk Karyawan (Anggota) menggunakan idkaryawan
     */
    public function loginKaryawan(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'idkaryawan' => 'required|string',
            'password' => 'required',
        ]);

        // Proses pencocokan (Attempt) login
        if (Auth::guard('karyawan')->attempt($credentials)) {
            $request->session()->regenerate();

            // SIMPAN WAKTU LOGIN TERAKHIR KE SESSION
            // Ini berfungsi agar buku yang dibuat sebelum login ini tidak dihitung sebagai notifikasi baru
            session(['last_login_at' => now()]);

            // JIKA BERHASIL: Arahkan ke halaman member
            return redirect()->intended(route('member.index'));
        }

        // JIKA GAGAL: Kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'idkaryawan' => 'ID Karyawan atau Password tidak cocok dengan data kami.',
        ])->onlyInput('idkaryawan');
    }

    /**
     * Proses Login untuk Admin menggunakan username (atau email)
     */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->login, // Menggunakan kolom username sesuai database
            'password' => $request->password
        ];

        // Cek autentikasi menggunakan guard 'web' (tabel users)
        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Mengarahkan ke halaman index admin (pastikan rute /admin/index ada)
            return redirect()->intended('/admin/index');
        }

        return back()->withErrors([
            'login' => 'Username atau kata sandi admin salah.',
        ])->onlyInput('login');
    }

    /**
     * Proses Logout (Bisa dipakai keduanya atau dipisah)
     */
    public function logout(Request $request)
    {
        // Logout dari guard karyawan jika sedang login sebagai karyawan
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
        }

        // Logout dari guard web jika sedang login sebagai admin
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
