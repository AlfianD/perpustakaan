<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Karyawan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Judul Buku (Menghitung jumlah baris/judul di tabel buku)
        $totalJudulBuku = Buku::count();

        // 2. Total Fisik Buku (Menjumlahkan isi kolom 'jumlah' dari semua buku)
        $totalFisikBuku = Buku::sum('jumlah');

        // 3. Karyawan Aktif
        $totalKaryawan = Karyawan::count();

        // 4. Sedang Dipinjam (Menghitung transaksi dengan status 'Dipinjam')
        $bukuDipinjam = Transaksi::where('status', 'Dipinjam')->count();

        // 5. Riwayat Transaksi Terbaru (Ambil 5 transaksi terakhir untuk tabel di bawah)
        $transaksiTerbaru = Transaksi::with(['karyawan', 'buku'])->latest()->take(5)->get();

        return view('admin.index', compact(
            'totalJudulBuku',
            'totalFisikBuku',
            'totalKaryawan',
            'bukuDipinjam',
            'transaksiTerbaru'
        ));
    }
}
