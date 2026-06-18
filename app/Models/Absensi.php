<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // 1. Memberi tahu nama tabel yang benar
    protected $table = 'absensi';

    // 2. Mengizinkan kolom-kolom ini untuk diisi data (Mass Assignment)
    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'shift',
        'status_kehadiran',
        'keterangan',
    ];

    // 3. Membuat Relasi: 1 Absensi ini adalah MILIK 1 User (Petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}