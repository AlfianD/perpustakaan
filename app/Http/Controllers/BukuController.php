<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori; // Pastikan model Kategori di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BukuController extends Controller
{
    /**
     * Tampilkan daftar buku (Read)
     */
    public function index()
    {
        // Ubah get() menjadi paginate(10) untuk menampilkan 10 data per halaman
        // Jika sebelumnya ada query pencarian, tetap biarkan, ganti akhirnya saja.
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        return view('admin.kelolabuku.index', compact('bukus'));
    }

    /**
     * Tampilkan form tambah buku (Create - View)
     */
    public function create()
    {
        // Mengambil data kategori untuk diletakkan di dalam dropdown (select)
        $kategoris = Kategori::all();
        return view('admin.kelolabuku.createbook', compact('kategoris'));
    }

    /**
     * Simpan data buku baru ke database (Create - Action)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'tahun_terbit' => 'required|digits:4',
            'jumlah' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string', // Validasi deskripsi
        ]);

        $coverPath = null;
        // Cek apakah ada file cover yang di-upload
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('cover-buku', 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah' => $request->jumlah,
            'cover' => $coverPath,
            'deskripsi' => $request->deskripsi, // Simpan deskripsi
        ]);

        return redirect()->route('admin.kelolabuku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit buku (Update - View)
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.kelolabuku.editbook', compact('buku', 'kategoris'));
    }

    /**
     * Proses update data buku (Update - Action)
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'tahun_terbit' => 'required|digits:4',
            'jumlah' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $coverPath = $buku->cover;

        // Jika admin mengupload cover baru, hapus cover lama dan simpan yang baru
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $coverPath = $request->file('cover')->store('cover-buku', 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kategori_id' => $request->kategori_id,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah' => $request->jumlah,
            'cover' => $coverPath,
        ]);

        return redirect()->route('admin.kelolabuku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function cetakQr($id)
    {
        $buku = Buku::findOrFail($id);

        // Membuat URL khusus untuk buku ini
        $urlBuku = route('member.scan', $buku->id);

        // Generate QR Code format SVG
        $qrCode = QrCode::size(250)->generate($urlBuku);

        return view('admin.kelolabuku.cetak_qr', compact('buku', 'qrCode'));
    }
    /**
     * Hapus data buku (Delete)
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file gambar cover dari storage sebelum menghapus data dari database
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.kelolabuku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
