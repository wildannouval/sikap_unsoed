<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $table = 'distribusis';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_distribusi' => 'date',
    ];

    // Relasi: Catatan distribusi ini milik satu pengajuan Kp
    public function pengajuanKp()
    {
        return $this->belongsTo(PengajuanKp::class,'pengajuan_kp_id');
    }

    // Relasi: Catatan distribusi ini untuk satu mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
