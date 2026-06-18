<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kejadian extends Model
{
    use HasFactory;

    protected $table = 'kejadian';

    protected $fillable = [
        'user_id',
        'tanggal_kejadian',
        'waktu_kejadian',
        'jenis_kejadian',
        'kronologi',
        'tindakan_diambil',
        'foto_kejadian',
    ];

    // Relasi: 1 Kejadian dilaporkan oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}