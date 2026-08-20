<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// 1. Perbaiki import di bawah ini kembali ke 'User'
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\KaryawanFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    // 2. Pindahkan $fillable dan $hidden ke dalam class dengan format property biasa
    protected $fillable = [
        'name',
        'idkaryawan',
        'divisi',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * RELASI: Karyawan memiliki banyak (HasMany) Transaksi
     * Relasi ini dibutuhkan untuk menghitung jumlah buku yang sedang dipinjam
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'karyawan_id', 'id');
    }
}
