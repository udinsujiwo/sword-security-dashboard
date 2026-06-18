<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarian extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'laporan_harian';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_laporan',
        'uraian_kegiatan',
        'kondisi',
        'foto_bukti',
    ];

    // Relasi: 1 Laporan ditulis oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}