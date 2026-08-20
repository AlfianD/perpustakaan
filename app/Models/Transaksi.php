<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import fitur SoftDeletes

class Transaksi extends Model
{
    use HasFactory, SoftDeletes; // Aktifkan SoftDeletes di sini

    /**
     * Tentukan nama tabel secara eksplisit (Opsional)
     * Secara default Laravel mencari tabel 'transaksis'. 
     * Buka komentar jika nama tabel di database-mu adalah 'transaksi'.
     */
    protected $table = 'transaksis';

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'karyawan_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
    ];

    /**
     * Casting tipe data kolom.
     * Mengubah format tanggal dari database menjadi instance Carbon (Date) 
     * agar mudah diformat saat ditampilkan di Blade.
     */
    protected function casts(): array
    {
        return [
            'tgl_pinjam' => 'date',
            'tgl_kembali' => 'date',
        ];
    }

    /**
     * RELASI: Transaksi ini milik (BelongsTo) seorang Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id');
    }

    /**
     * RELASI: Transaksi ini meminjam sebuah Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id');
    }
}
