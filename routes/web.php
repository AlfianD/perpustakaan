<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController; // Tambahkan ini
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

// Halaman Login Utama
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Proses Login
Route::post('/login/karyawan', [AuthController::class, 'loginKaryawan'])->name('login.karyawan');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin');

// Proses Logout (Bisa diletakkan di bawah rute login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Admin setelah berhasil login
Route::middleware(['auth:web', 'prevent-back-history'])->group(function () {
    Route::get('/admin/index', [DashboardController::class, 'index'])->name('admin.index');

    // Rute Kelola Buku & Transaksi (Sementara masih statis)
    // Rute Katalog Buku
    Route::get('/admin/kelola-buku', [BukuController::class, 'index'])->name('admin.kelolabuku.index');
    Route::get('/admin/kelola-buku/create', [BukuController::class, 'create'])->name('admin.kelolabuku.create');
    Route::post('/admin/kelola-buku', [BukuController::class, 'store'])->name('admin.kelolabuku.store');
    Route::get('/admin/kelola-buku/{id}/edit', [BukuController::class, 'edit'])->name('admin.kelolabuku.edit');
    Route::put('/admin/kelola-buku/{id}', [BukuController::class, 'update'])->name('admin.kelolabuku.update');
    Route::delete('/admin/kelola-buku/{id}', [BukuController::class, 'destroy'])->name('admin.kelolabuku.destroy');

    // Rute Kategori Buku (Terpisah)
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/admin/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    // --- DUA RUTE INI WAJIB DITAMBAHKAN UNTUK FITUR EDIT ---
    Route::get('/admin/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // --- Persiapan Rute Transaksi (Akan dibuat di tahap selanjutnya) ---
    // Route::get('/admin/kelola-transaksi', [TransaksiController::class, 'index'])->name('admin.kelolatransaksi.index');
    // Rute untuk mengelola transaksi di sisi Admin
    // Menampilkan halaman kelola transaksi
    Route::get('/admin/kelola-transaksi', [App\Http\Controllers\TransaksiController::class, 'index'])->name('admin.kelolatransaksi.index');

    // Menyimpan transaksi peminjaman baru (Create)
    Route::post('/admin/kelola-transaksi', [App\Http\Controllers\TransaksiController::class, 'store'])->name('admin.kelolatransaksi.store');

    // Memproses pengembalian buku (Update)
    Route::put('/admin/kelola-transaksi/{id}/kembali', [App\Http\Controllers\TransaksiController::class, 'kembalikan'])->name('admin.kelolatransaksi.kembalikan');
    // ==========================================
    // RUTE CRUD KELOLA USER (KARYAWAN)
    // ==========================================
    Route::get('/admin/kelola-user', [KaryawanController::class, 'index'])->name('admin.user.index');

    Route::get('/admin/kelola-user/create', [KaryawanController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/kelola-user', [KaryawanController::class, 'store'])->name('admin.user.store');

    Route::get('/admin/kelola-user/{id}/edit', [KaryawanController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/kelola-user/{id}', [KaryawanController::class, 'update'])->name('admin.user.update');

    Route::delete('/admin/kelola-user/{id}', [KaryawanController::class, 'destroy'])->name('admin.user.destroy');

    // Rute untuk melihat/cetak QR Code Buku
    Route::get('/admin/kelola-buku/{id}/cetak-qr', [BukuController::class, 'cetakQr'])->name('admin.kelolabuku.cetak_qr');
});

// ==========================================
// RUTE KARYAWAN (MEMBER) SETELAH LOGIN
// ==========================================
// Middleware disesuaikan dengan nama guard-mu (misal: auth:karyawan)
// Route::middleware('auth:karyawan')->group(function () {
//     Route::get('/member/index', [MemberController::class, 'index'])->name('member.index');
//     // Rute AJAX untuk Tombol Interaktif
//     Route::post('/member/pinjam-buku', [App\Http\Controllers\MemberController::class, 'pinjamBuku'])->name('member.pinjam');
//     Route::post('/member/kembalikan-buku', [App\Http\Controllers\MemberController::class, 'kembalikanBuku'])->name('member.kembali');
// });


// Rute khusus untuk Member (Karyawan) yang sudah login
Route::prefix('member')->name('member.')->middleware(['auth:karyawan', 'prevent-back-history'])->group(function () {
    // Halaman Beranda & Katalog Buku
    Route::get('/index', [MemberController::class, 'index'])->name('index');

    // Halaman Riwayat Peminjaman
    Route::get('/riwayat', [MemberController::class, 'riwayat'])->name('riwayat');

    // Rute AJAX untuk Tombol Interaktif
    Route::post('/pinjam-buku', [MemberController::class, 'pinjam'])->name('pinjam');
    Route::post('/kembalikan-buku', [MemberController::class, 'kembalikan'])->name('kembalikan');
    // Rute hasil scan QR Code Buku
    Route::get('/scan/{id}', [MemberController::class, 'scan'])->name('scan');

    // --- TAMBAHKAN RUTE INI UNTUK MEMBERSIHKAN NOTIFIKASI ---
    Route::post('/baca-notifikasi', function () {
        session(['notif_read_at' => now()]);
        return response()->json(['success' => true]);
    })->name('baca.notifikasi');
});
