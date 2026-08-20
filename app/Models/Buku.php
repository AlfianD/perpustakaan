<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes; // Tambahkan ini jika kamu nanti ingin membuat dummy data (Seeder/Factory)

    protected $table = 'bukus';

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal.
     * id tidak dimasukkan karena otomatis (Auto Increment).
     */
    protected $fillable = [
        'kategori_id',
        'judul',
        'penulis',
        'tahun_terbit',
        'jumlah',
        'cover',
        'deskripsi',
    ];

    /**
     * RELASI ANTAR TABEL (Eloquent Relationships)
     * Buku ini berelasi "BelongsTo" (Milik Dari) sebuah Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    /**
     * RELASI: Satu Buku bisa memiliki banyak riwayat Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'buku_id', 'id');
    }
}
