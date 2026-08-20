<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Tampilkan halaman daftar kategori (Read)
     */
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('admin.kelolabuku.kategori', compact('kategoris'));
    }

    /**
     * Tampilkan form tambah kategori (Create - View)
     */
    public function create()
    {
        return view('admin.kelolabuku.createkategori');
    }

    /**
     * Simpan data kategori baru (Create - Action)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }


    /**
     * Tampilkan form edit kategori (Update - View)
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kelolabuku.editkategori', compact('kategori'));
    }

    /**
     * Simpan perubahan data kategori (Update - Action)
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            // Pengecualian ID agar nama kategori tidak dianggap duplikat dengan miliknya sendiri
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }


    /**
     * Hapus kategori (Delete)
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
