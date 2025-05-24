<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $fillable = [
        'user_id',
        'jurusan_id',
        'nim',
        'no_hp',
        'tahun_masuk',
        'alamat',
    ];

    // Relasi: Profil mahasiswa ini dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Mahasiswa ini berasal dari satu jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi: Satu mahasiswa bisa memiliki banyak pengajuan KP
    public function pengajuanKps()
    {
        return $this->hasMany(PengajuanKp::class);
    }
}
