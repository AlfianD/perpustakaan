<?php

namespace App\Http\Controllers;

use App\Models\Karyawan; // Pastikan Model Karyawan di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Daftar Pilihan Divisi
    private $divisiList = [
        'Operations',
        'Digital',
        'Consultant',
        'Human Resource',
        'Marketing & Sales',
        'General Affair',
        'Finance & Accounting',
        'Research & Development'
    ];

    /**
     * Tampilkan halaman daftar Karyawan (Read)
     */
    public function index()
    {
        // Mengambil semua data karyawan, diurutkan dari yang terbaru
        $karyawans = Karyawan::latest()->get();
        return view('admin.kelolauser.index', compact('karyawans'));
    }

    /**
     * Tampilkan form tambah Karyawan (Create - View)
     */
    public function create()
    {
        $divisi = $this->divisiList;
        return view('admin.kelolauser.createuser', compact('divisi'));
    }

    /**
     * Simpan data Karyawan baru ke database (Create - Action)
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'idkaryawan' => 'required|string|unique:karyawans,idkaryawan|max:50',
            'divisi' => 'required|string',
            'password' => 'required|string|min:5',
        ], [
            'idkaryawan.unique' => 'ID Karyawan sudah digunakan, silakan gunakan ID lain.'
        ]);

        // 2. Simpan ke database
        Karyawan::create([
            'name' => $request->name,
            'idkaryawan' => $request->idkaryawan,
            'divisi' => $request->divisi,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.user.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit Karyawan (Update - View)
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $divisi = $this->divisiList;

        // Asumsi kamu membuat file edituser.blade.php nantinya
        return view('admin.kelolauser.edituser', compact('karyawan', 'divisi'));
    }

    /**
     * Simpan perubahan data Karyawan (Update - Action)
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'idkaryawan' => 'required|string|max:50|unique:karyawans,idkaryawan,' . $karyawan->id, // Abaikan ID saat ini
            'divisi' => 'required|string',
            'password' => 'nullable|string|min:5', // Nullable agar password tidak wajib diisi saat edit
        ]);

        // Siapkan data yang akan diupdate
        $data = [
            'name' => $request->name,
            'idkaryawan' => $request->idkaryawan,
            'divisi' => $request->divisi,
        ];

        // Jika form password diisi, update passwordnya (enkripsi dulu)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Hapus data Karyawan (Delete)
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.user.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
