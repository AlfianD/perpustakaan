<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Karyawan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // --- STATISTIK PEMINJAMAN ---
        $statDipinjam = Transaksi::where('status', 'Dipinjam')->count();

        $statTerlambat = Transaksi::where('status', 'Dipinjam')
            ->where('tgl_kembali', '<', $hariIni)
            ->count();

        $statJatuhTempo = Transaksi::where('status', 'Dipinjam')
            ->whereDate('tgl_kembali', $hariIni)
            ->count();

        $statDikembalikan = Transaksi::where('status', 'Dikembalikan')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->count();

        // --- DATA TABEL PEMINJAMAN ---
        $transaksis = Transaksi::with(['karyawan', 'buku'])->latest()->get();

        // --- DATA TABEL ANGGOTA (KARYAWAN) ---
        $anggotas = Karyawan::withCount(['transaksis as sedang_dipinjam_count' => function ($query) {
            $query->where('status', 'Dipinjam');
        }])->latest()->get();
        // --- DATA UNTUK DROPDOWN MODAL PINJAM BARU ---
        $karyawans = Karyawan::orderBy('name', 'asc')->get();
        $bukus = Buku::where('jumlah', '>', 0)->orderBy('judul', 'asc')->get(); // Hanya buku yang stoknya > 0

        return view('admin.kelolatransaksi.index', compact(
            'statDipinjam',
            'statTerlambat',
            'statJatuhTempo',
            'statDikembalikan',
            'transaksis',
            'anggotas',
            'karyawans',
            'bukus'
        ));
    }

    /**
     * PROSES CATAT PEMINJAMAN BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'buku_id' => 'required|exists:bukus,id',
            'tgl_kembali' => 'required|date|after_or_equal:today',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Pastikan stok masih ada
        if ($buku->jumlah <= 0) {
            return back()->with('error', 'Stok buku ini sedang kosong atau habis dipinjam.');
        }

        // Kurangi stok buku
        $buku->decrement('jumlah');

        // Buat data transaksi
        Transaksi::create([
            'karyawan_id' => $request->karyawan_id,
            'buku_id' => $request->buku_id,
            'tgl_pinjam' => Carbon::today(),
            'tgl_kembali' => $request->tgl_kembali, // Jatuh Tempo
            'status' => 'Dipinjam',
        ]);

        return back()->with('success', 'Transaksi peminjaman berhasil dicatat dan stok buku telah dikurangi.');
    }

    /**
     * PROSES PENGEMBALIAN BUKU
     */
    public function kembalikan($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status === 'Dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Ubah status menjadi dikembalikan
        $transaksi->update([
            'status'      => 'Dikembalikan',
            'tgl_kembali' => Carbon::now() // <--- Terisi tanggal aktual pengembalian
            // Jika Anda punya kolom 'tgl_aktual_kembali', bisa diupdate disini. 
            // Namun karena belum ada, kita biarkan tgl_kembali sebagai log jatuh tempo.
        ]);


        // Tambah/Kembalikan stok fisik buku
        if ($transaksi->buku) {
            $transaksi->buku->increment('jumlah');
        }

        return back()->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui.');
    }
}
