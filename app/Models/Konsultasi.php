<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;
    protected $table = 'konsultasis';

    protected $guarded = ['id'];

    // Relasi: Satu sesi konsultasi ini milik satu pengajuan kp
    public function pengajuanKp()
    {
        return $this->belongsTo(PengajuanKp::class,'pengajuan_kp_id');
    }

    // Relasi: Sesi konsultasi ini dilakukan oleh satu mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi: Sesi konsultasi ini dilakukan dengan satu dosen pembimbing
    public function dosenPembimbing()
    {
        return $this->belongsTo(Dosen::class,'dosen_pembimbing_id');
    }
}
