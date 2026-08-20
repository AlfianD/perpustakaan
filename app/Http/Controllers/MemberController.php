<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <--- 1. Import Facades DB
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $karyawanId = Auth::guard('karyawan')->id();

        // Statistik Dashboard Member
        $totalBukuTersedia = Buku::count(); // Menghitung total seluruh judul buku yang terdaftar
        $totalJudulBuku = Buku::count();
        $totalPernahDipinjam = Transaksi::where('karyawan_id', $karyawanId)->count();
        $totalSedangDipinjam = Transaksi::where('karyawan_id', $karyawanId)->where('status', 'Dipinjam')->count();

        // Query Filter Katalog Buku
        $query = Buku::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'tersedia') {
                $query->where('jumlah', '>', 0);
            } elseif ($request->status === 'habis') {
                $query->where('jumlah', '<=', 0);
            }
        }

        if ($request->filled('sort') && $request->sort === 'judul') {
            $query->orderBy('judul', 'asc');
        } else {
            $query->latest();
        }

        $books = $query->get();
        $kategoris = Buku::with('kategori')->get()->pluck('kategori.nama_kategori')->filter()->unique()->sort();

        // Buku yang sedang dipinjam oleh user aktif
        $activeLoans = Transaksi::with('buku')
            ->where('karyawan_id', $karyawanId)
            ->where('status', 'Dipinjam')
            ->get();

        return view('member.index', compact(
            'books',
            'kategoris',
            'totalBukuTersedia',
            'totalJudulBuku',
            'totalPernahDipinjam',
            'totalSedangDipinjam',
            'activeLoans'
        ));
    }

    public function riwayat()
    {
        $karyawanId = Auth::guard('karyawan')->id();

        $totalSedangDipinjam = Transaksi::where('karyawan_id', $karyawanId)->where('status', 'Dipinjam')->count();
        $totalPernahDipinjam = Transaksi::where('karyawan_id', $karyawanId)->count();

        $activeLoans = Transaksi::with('buku')
            ->where('karyawan_id', $karyawanId)
            ->where('status', 'Dipinjam')
            ->get();

        $historyLoans = Transaksi::with('buku')
            ->where('karyawan_id', $karyawanId)
            ->latest('tgl_pinjam') // <--- Diubah dari tanggal_pinjam ke tgl_pinjam
            ->get();

        return view('member.riwayat', compact(
            'totalSedangDipinjam',
            'totalPernahDipinjam',
            'activeLoans',
            'historyLoans'
        ));
    }

    public function pinjam(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:bukus,id']);

        $karyawanId = Auth::guard('karyawan')->id();
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->jumlah <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok buku habis.'], 400);
        }

        $sudahPinjam = Transaksi::where('karyawan_id', $karyawanId)
            ->where('buku_id', $buku->id)
            ->where('status', 'Dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return response()->json(['success' => false, 'message' => 'Anda sedang meminjam buku ini.'], 400);
        }

        // Gunakan DB::transaction untuk memastikan keamanan data
        try {
            DB::transaction(function () use ($karyawanId, $buku) {
                // 1. Kurangi stok buku
                $buku->decrement('jumlah');

                // 2. Buat data transaksi (tgl_kembali diset null karena belum dikembalikan)
                Transaksi::create([
                    'karyawan_id' => $karyawanId,
                    'buku_id'     => $buku->id,
                    'tgl_pinjam'  => Carbon::now(),
                    'tgl_kembali' => null, // <--- Ubah jadi null
                    'status'      => 'Dipinjam'
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dipinjam.',
                'borrowDate' => Carbon::now()->toDateString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal meminjam buku: ' . $e->getMessage()
            ], 500);
        }
    }

    public function kembalikan(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:bukus,id']);

        $karyawanId = Auth::guard('karyawan')->id();

        $transaksi = Transaksi::where('karyawan_id', $karyawanId)
            ->where('buku_id', $request->buku_id)
            ->where('status', 'Dipinjam')
            ->first();

        if (!isset($transaksi)) {
            return response()->json(['success' => false, 'message' => 'Data peminjaman aktif tidak ditemukan.'], 404);
        }

        $transaksi->update([
            'status'      => 'Dikembalikan',
            'tgl_kembali' => Carbon::now() // <--- Terisi tanggal aktual pengembalian
        ]);

        $transaksi->buku->increment('jumlah');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan.',
            'returnDate' => Carbon::now()->toDateString()
        ]);
    }

    // --- TAMBAHKAN KODE INI DI SINI ---
    public function scan($id)
    {
        $karyawanId = Auth::guard('karyawan')->id();
        $buku = Buku::findOrFail($id);

        $isHabis = $buku->jumlah <= 0;
        $isDipinjamUser = Transaksi::where('karyawan_id', $karyawanId)
            ->where('buku_id', $buku->id)
            ->where('status', 'Dipinjam')
            ->exists();

        return view('member.scan_confirm', compact('buku', 'isHabis', 'isDipinjamUser'));
    }
}
